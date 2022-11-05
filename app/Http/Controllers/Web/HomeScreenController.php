<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\SaveProject;
use App\Models\Addon;
use App\Models\Project;
use App\Models\ProjectProposal;
use App\Models\Skill;
use App\Models\ServiceCategory;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class HomeScreenController extends Controller
{

    public function index() {
        $freelancers = ProjectProposal::select('freelancer_id', DB::raw('COUNT(freelancer_id) AS occurrences'))
        ->groupBy('freelancer_id')
        ->where('status', 'completed')
        ->orderBy('occurrences', 'DESC')
        ->limit(10)
        ->with('freelancer')
        ->get();
        return view('welcome', compact('freelancers'));
    }

    public function services(Request $request) {
        $title = $request->input('title');
        $categories = $request->input('categories') ? $request->input('categories') : [];
        $price_min = $request->input('price-min');
        $price_max = $request->input('price-max');
        $my_range = $request->input('my_range');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');

        $services = Service::select('*')->when($title, function ($q) use ($title) {
            return $q->where(DB::raw('lower(name)'), 'like', '%' . strtolower($title) . '%');
        })
        ->when($categories, function ($q) use ($categories) {
            if($categories[0]) {
                return $q->whereIn('service_category', $categories);
            }
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
        ->where('expiration_date', '>' , Carbon::now())
        ->with('category')
        ->cursorPaginate(10);
        $service_categories = ServiceCategory::all();

        $queries = [
            'title' => $title,
            'categories' => $categories,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'my_range' => $my_range,
            'type' => $type,
        ];

        return view('CustomerScreens.home_screens.service-search', compact('services', 'service_categories', 'queries'));
    }

    public function service(Request $request) {
        $service = Service::where('id', $request->id)->with('category', 'freelancer')->first();
        $addons = Addon::where('user_role_id', $service->freelancer_id)->limit(5)->get();
        return view('CustomerScreens.home_screens.service', compact('service', 'addons'));
    }

    public function projects(Request $request) {
        $title = $request->input('title');
        $categories = $request->input('categories') ? $request->input('categories') : [];
        $price_min = $request->input('price-min');
        $price_max = $request->input('price-max');
        $my_range = $request->input('my_range');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');

        $projects = Project::select('*')
        ->where('expiration_date', '>' , Carbon::now())
        ->where('isExpired', 0)
        ->orWhereNull('status')
        ->when($title, function ($q) use ($title) {
            return $q->where(DB::raw('lower(title)'), 'like', '%' . strtolower($title) . '%');
        })
        ->when($categories, function ($q) use ($categories) {
            if($categories[0]) {
                return $q->whereIn('category_id', $categories);
            }
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(projects.latitude))
            * cos(radians(projects.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(projects.latitude))) AS distance"))->having('distance', '<=', '10')->orderBy("distance",'asc');
        })
        ->when($type, function ($q) use ($type) {
            return $q->where('project_type', $type);
        })
        ->when($my_range, function ($q) use ($my_range) {
            $range = explode(';', $my_range);
            return $q->whereBetween('cost', [$range[0], $range[1]]);
        })
        ->with('category', 'employer')
        ->cursorPaginate(10);

        $service_categories = ServiceCategory::all();
        // dd($projects);

        $queries = [
            'title' => $title,
            'categories' => $categories,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'my_range' => $my_range,
            'type' => $type,
        ];

        return view('CustomerScreens.home_screens.project-search', compact('projects', 'service_categories', 'queries'));
    }

    public function project(Request $request) {
        $project =  Project::where('id', $request->id)->with('employer', 'category')->first();
        $project->setSkills(json_decode($project->skills));
        $project->getSkills();
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $save_project = session()->has('id') ? SaveProject::where('project_id', $project->id)->where('follower_id', $freelancer->id)->first() : null;
        $skills_array = Skill::whereIn('id', json_decode($project->skills))->get();
        return view('CustomerScreens.home_screens.project', compact('project', 'save_project'));
    }

    public function freelancers(Request $request) {
        $skills = Skill::all();

        // filters
        $title = $request->input('title');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $my_range = $request->input('my_range');
        $price_min = $request->input('price-min');
        $price_max = $request->input('price-max');
        $freelancer_skills = $request->input('skill') ? $request->input('skill') : [];
        $freelance_type = $request->input('freelance_type') ? $request->input('freelance_type') : [];

        $freelancers = Freelancer::select('*')->when($title, function ($q) use ($title) {
            return $q->where(DB::raw('lower(display_name)'), 'like', '%' . strtolower($title) . '%');
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(user_freelancer.latitude))
            * cos(radians(user_freelancer.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(user_freelancer.latitude))) AS distance"))->having('distance', '<=', '10')->orderBy("distance",'asc');
        })
        ->when($my_range, function ($q) use ($my_range) {
            $range = explode(';', $my_range);
            return $q->whereBetween('hourly_rate', [intval($range[0]), intval($range[1])]);
        })
        ->when($freelance_type, function ($q) use ($freelance_type) {
            if($freelance_type[0]) {
                return $q->whereIn('freelancer_type', $freelance_type);
            }
        })
        ->with('user', 'certificates', 'experiences', 'educations', 'skills', 'services')
        ->when($freelancer_skills, function ($q) use ($freelancer_skills) {
            if($freelancer_skills[0]) {
                $q->whereHas('skills', function ($query) use($freelancer_skills){
                    return $query->whereIn('skill_id', $freelancer_skills);
                });
            }
        })
        ->cursorPaginate(10);

        $queries = [
            'title' => $title,
            'address' => $address,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'my_range' => $my_range,
            'freelancer_skills' => $freelancer_skills,
            'freelance_type' => $freelance_type,
        ];

        return view('CustomerScreens.home_screens.freelancer-search', compact('freelancers', 'skills', 'queries'));
    }

    public function contact_us() {
        return view("CustomerScreens.contact-us");
    }

    public function the_process() {
        return view('CustomerScreens.process');
    }
}
