<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Service;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\SaveProject;
use App\Models\Addon;
use App\Models\Project;
use App\Models\ProjectProposal;
use App\Models\Skill;
use App\Models\ServiceCategory;
use App\Models\FreelancerFollower;
use App\Models\EmployerFollower;
use App\Models\FreelancerReview;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Luigel\Paymongo\Facades\Paymongo;

use Stevebauman\Location\Facades\Location;

class HomeScreenController extends Controller
{

    public function index() {
        $freelancers = Freelancer::limit(8)->with('user', 'skills')->get();
        $projects = Project::where('status', 'pending')->limit(6)->with('category', 'employer')->latest('id')->get();
        return view('welcome', compact('freelancers', 'projects'));
    }

    public function freelancer(Request $request) {
        // Data of Freelancer
        $user = User::where('username', $request->username)->with('freelancer')->firstOrFail();
        $freelancer = Freelancer::where('user_id', $user->id)->with('user', 'certificates', 'experiences', 'educations', 'services', 'skills', 'projects', 'projects_completed')->firstOrFail();
        $active_services = $freelancer->services()->where('expiration_date', '>', Carbon::now())->get();
        $featured_services = $freelancer->services()->where('type', 'featured')->where('expiration_date', '>', Carbon::now())->get();

        $my_profile = Employer::where('user_id', session()->get('id'))->with('projects')->first();


        $reviews = FreelancerReview::where('freelancer_id', $freelancer->id)->orderByRaw('LENGTH(review) DESC')->orderBy('review')->with('reviewer')->get();
        $follow_freelancer = false;
        if($my_profile) $follow_freelancer = FreelancerFollower::where('freelancer_id', $freelancer->id)->where('follower_id', $my_profile->id)->exists();

        return view('UserAuthScreens.user.freelancer.view-freelancer', compact('freelancer', 'featured_services', 'active_services', 'follow_freelancer', 'my_profile', 'reviews'));
    }

    public function employer(Request $request) {
        $employer = Employer::where('user_id', $request->id)->with('user', 'projects')->firstOrFail();
        $completed_projects = Project::where('employer_id', $employer->id)->where('status', 'completed')->get();

        $my_profile = Freelancer::where('user_id', session()->get('id'))->first();
        $follow_employer = $my_profile ? $follow_employer = EmployerFollower::where('employer_id', $employer->id)->where('follower_id', $my_profile->id)->exists() : false;

        return view('UserAuthScreens.user.employer.view-employer', compact('employer', 'completed_projects', 'follow_employer'));
    }

    public function services(Request $request) {
        $services = Service::with('category')->paginate(10);
        $service_categories = ServiceCategory::toBase()->get();

        return view('CustomerScreens.home_screens.service.service-search', compact('services', 'service_categories'));
    }

    public function fetch_services(Request $request) {
        abort_if(!$request->ajax(), 403);

        $title = $request->input('title');
        $categories = $request->input('categories') ? json_decode($request->input('categories')) : [];
        $price_min = $request->input('price-min');
        $price_max = $request->input('price-max');
        $my_range = $request->input('my_range');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');

        $services = Service::select('*')
        ->where(DB::raw('lower(name)'), 'like', '%' . strtolower($title) . '%')
        ->when($categories, function ($q) use ($categories) {
            if($categories[0]) return $q->whereIn('service_category', $categories);
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(services.latitude))
            * cos(radians(services.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(services.latitude))) AS distance"))->having('distance', '<=', '10')->orderBy("distance",'asc');
        })
        ->when($type, function ($q) use ($type) {
            return $q->where('type', $type);
        })
        ->when($my_range, function ($q) use ($my_range) {
            $range = explode(';', $my_range);
            return $q->whereBetween('cost', [$range[0], $range[1]]);
        })
        ->with('category', 'freelancer')
        ->latest('id')
        ->paginate(10);

        $test = 'test';

        $view_data = view('CustomerScreens.home_screens.service.services', compact('services'))->render();

        return response()->json([
            'view_data' => $view_data,
            'services' => $latitude && $longitude ? $services->toArray() : []
        ]);
    }

    public function service(Request $request) {
        $service = Service::where('id', $request->id)->with('category', 'freelancer')->firstOrFail();
        $addons = Addon::where('user_role_id', $service->freelancer_id)->limit(5)->get();
        return view('CustomerScreens.home_screens.service.service', compact('service', 'addons'));
    }

    public function projects(Request $request) {
        #get user data
        $user_id = session()->get('id');
        $user = session()->get('role') == 'freelancer' ? Freelancer::where('user_id', $user_id)->first() : Employer::where('user_id', $user_id)->first();

        $projects = Project::select('*')
        ->when($user_id && session()->get('role') == 'employer', function ($q) use ($user, $user_id) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $user->latitude . "))
            * cos(radians(projects.latitude))
            * cos(radians(projects.longitude) - radians(" . $user->longitude . "))
            + sin(radians(" .$user->latitude. "))
            * sin(radians(projects.latitude))) AS distance"))->having('distance', '<=', '10')->orderBy("distance",'asc')->where('id', '!=', $user->id);
        })
        ->with('category', 'employer')
        ->latest('id')
        ->paginate(12);

        $service_categories = ServiceCategory::toBase()->get();
        $skills = Skill::toBase()->get();
        return view('CustomerScreens.home_screens.project.project-search', compact('projects', 'service_categories', 'skills'));
    }

    public function fetch_projects(Request $request) {
        abort_if(!$request->ajax(), 404);

        $title = $request->input('title');
        $categories = $request->input('categories') ? json_decode($request->input('categories')) : [];
        $my_range = $request->input('my_range');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');
        $radius = $request->input('radius') ? $request->input('radius') : 10;
        $result = $request->input('result') ? $request->input('result') : 5;

        $projects = Project::select('*')
        ->when($title, function($q) use ($title) {
            return $q->where(DB::raw('lower(title)'), 'like', '%' . strtolower($title) . '%');
        })
        ->when($categories, function ($q) use ($categories) {
            if($categories[0]) return $q->whereIn('category_id', $categories);
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude, $radius) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(projects.latitude))
            * cos(radians(projects.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(projects.latitude))) AS distance"))->having('distance', '<=', $radius)->orderBy("distance", 'asc');
        })
        ->when($type, function ($q) use ($type) {
            return $q->where('project_type', $type);
        })
        ->when($my_range, function ($q) use ($my_range) {
            $range = explode(';', $my_range);
            return $q->whereBetween('cost', [$range[0], $range[1]]);
        })
        ->with('category', 'employer')
        ->latest('id')
        ->paginate(12);

        $view_data = view('CustomerScreens.home_screens.project.projects', compact('projects'))->render();

        return response()->json([
            'view_data' => $view_data,
            'projects' => $projects,
            'radius' => $radius
        ]);
    }

    public function project(Request $request) {
        $project =  Project::where('title', $request->title)->with('employer', 'category')->firstOrFail();
        # if the user is login as freelancer
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();

        $isAvailableDate = true;
        if($freelancer) $isAvailableDate = in_array($project->start_date, $freelancer->notAvailableDates()) || in_array($project->end_date, $freelancer->notAvailableDates()) ? false : true;

        $save_project = $freelancer ? SaveProject::where('project_id', $project->id)->where('follower_id', $freelancer->id)->first() : null;
        $proposal = $freelancer ? ProjectProposal::where('project_id', $project->id)->where('freelancer_id', $freelancer->id)->first() : false;

        return view('CustomerScreens.home_screens.project.project', compact('project', 'save_project', 'proposal', 'freelancer', 'isAvailableDate'));
    }

    public function freelancers(Request $request) {
        $skills = Skill::all();
        $ip = $request->ip();
        $currentUserInfo = Location::get();
        # get all freelancers and create pagination
        $freelancers = Freelancer::select('*')->paginate(9);
        return view('CustomerScreens.home_screens.freelancer.freelancer-search', compact('freelancers', 'skills'));
    }

    public function fetch_freelancers(Request $request) {
        abort_if(!$request->ajax(), 404);

        // data filters
        $title = $request->input('title');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $my_range = $request->input('hourly_rate');
        $radius = $request->input('radius');
        $result = $request->input('result');
        $sort = $request->input('sort');

        $freelancer_skills = $request->input('skills') ? json_decode($request->input('skill')) : [];
        $freelance_type = $request->input('freelance_type') ? json_decode($request->input('freelance_type')) : [];

        $freelancers = Freelancer::select('*')->when($title, function ($q) use ($title) {
            return $q->where(DB::raw('lower(display_name)'), 'like', '%' . strtolower($title) . '%')
                    ->orWhere(DB::raw('lower(tagline)'), 'like', '%' . strtolower($title) . '%')
                    ->orWhere(DB::raw('lower(description)'), 'like', '%' . strtolower($title) . '%');
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude, $radius, $sort) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(user_freelancer.latitude))
            * cos(radians(user_freelancer.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(user_freelancer.latitude))) AS distance"))->having('distance', '<=', $radius)->orderBy("distance", 'asc');
        })

        ->with('user', 'certificates', 'experiences', 'educations', 'skills', 'services')
        ->paginate(9);

        $view_data = view('CustomerScreens.home_screens.freelancer.freelancers', compact('freelancers'))->render();

        return response()->json([
            'view_data' => $view_data,
            'freelancers' => $freelancers,
            'radius' => $radius,
        ]);

    }

    public function contact_us() {
        return view("CustomerScreens.contact-us");
    }

    public function the_process() {
        return view('CustomerScreens.process');
    }
}
