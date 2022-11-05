<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\Service;
use App\Models\ServicesProposal;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\ServiceCategory;
use App\Models\FreelancePackage;
use App\Models\EmployerPackage;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ServicesController extends Controller
{
    public function index() {
        $user_id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        $services = Service::where('freelancer_id', $freelancer->id)->where('expiration_date', '>=' , Carbon::now())->latest('id')->cursorPaginate(10);
        return view('UserAuthScreens.services.services', compact('services'));
    }

    public function create() {
        $categories = ServiceCategory::all();
        return view('UserAuthScreens.services.create-service', compact('categories'));
    }

    public function store(Request $request) {
        //check if the current plan is exceed in limit
        if($this->checkAvailableService($request->type)) return back()->with('fail', 'Sorry but your current plan exceed the limit. Wait for expiration then buy again');

        $request->validate([
            'name' => 'required',
            'cost' => 'required',
            'english_level' => 'required',
            'service_category' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'type' => 'required',
            'attachment' => 'required|max:2048',
        ]);

        $images = [];
        foreach ($request->file('attachment') as $key => $attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path().'/images/services', $image_name);
            array_push($images, $image_name);
        }

        $json_images = json_encode($images);
        $user_id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();

        $save = Service::create([
            'freelancer_id' => $freelancer->id,
            'name' => $request->name,
            'cost' => $request->cost,
            'english_level' => $request->english_level,
            'service_category' => $request->service_category,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'type' => $request->type,
            'attachments' => $json_images,
            'expiration_date' => $freelancer->package_date_expiration
        ]);

        return redirect('/services')->with('success', 'Service Added Successfully');
    }

    public function edit(Request $request) {
        $user_id = session()->get('id');
        $role = session()->get('role');
        $user = Freelancer::where('user_id', $user_id)->first();
        $service = Service::where('id', $request->id)->first();
        $categories = ServiceCategory::all();
        $service_images = json_decode($service->attachments);

        $pending_offers = ServicesProposal::where('seller_id', $user->id)
        ->where('service_id', $service->id)
        ->where('status', 'pending')
        ->where('isCancel', 0)
        ->with('service', 'employer')
        ->whereHas('service', function($q) {
            $q->where('expiration_date', '>=', Carbon::now());
        })
        ->cursorPaginate(10);

        return view('UserAuthScreens.services.edit-service', compact('service', 'categories', 'service_images', 'pending_offers'));
    }

    public function fetch_services_offer(Request $request) {
        $user_id = session()->get('id');
        $role = session()->get('role');
        $user = Freelancer::where('user_id', $user_id)->first();
        $service = Service::where('id', $request->id)->first();
        $pending_offers = ServicesProposal::where('seller_id', $user->id)
        ->where('service_id', $service->id)
        ->where('status', 'pending')
        ->where('isCancel', 0)
        ->with('service', 'employer')
        ->whereHas('service', function($q) {
            $q->where('expiration_date', '>=', Carbon::now());
        })
        ->cursorPaginate(10);
        return view('UserAuthScreens.services_proposals.freelancer.pending', compact('pending_offers'))->render();
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:services,id',
            'name' => 'required',
            'cost' => 'required|numeric',
            'freelancer' => 'required',
            'english_level' => 'required|in:Basic,Bilingual,Fluent,Professional',
            'service_category' => 'required',
            'location' => 'required',
            'description' => 'required',
            'type' => 'required|in:simple,featured',
        ]);

        $service = Service::where('id', $request->id)->first();
        $service_images = json_decode($service->attachments);
        if($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/services', $image_name);
                array_push($service_images, $image_name);
            }
        }

        $json_images = json_encode($service_images);

        $update = Service::where('id', $request->id)->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'freelancer_id' => $request->freelancer,
            'english_level' => $request->english_level,
            'service_category' => $request->service_category,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'type' => $request->type,
            'attachments' => $json_images,
        ]);

        if($update) {
            return back()->with('success', 'Update Successfully');
        }


    }

    public function remove_image(Request $request) {
        $key_id = $request->key_id;
        $service = Service::where('id', $request->id)->first();
        $service_images = json_decode($service->attachments);
        if(count($service_images) < 2) return response()->json(['status' => 424, 'message' => 'Fail! You only have one image. Keep this image for reference']);

        // Search image in array
        $found_image = in_array($service_images[$key_id], $service_images);
        if($found_image) {
            $image_path = public_path('/images/services/') . $service_images[$key_id];
            $remove_image = @unlink($image_path);

            if($key_id == 0) {
                array_shift($service_images);
            }else {
                unset($service_images[$key_id]);
            }


        }
        $service->attachments = json_encode($service_images);
        $save = $service->save();

        if($save) {
            return response()->json([
                'status' => 201,
                'message' => 'Remove Successfully'
            ]);
        }

    }

    public function destroy(Request $request) {
        $service = Service::where('id', $request->id)->first();
        $service_images = json_decode($service->attachments);

        foreach ($service_images as $key => $image) {
            $image_path = public_path('/images/services/') . $image;
            $remove_image = @unlink($image_path);
        }

        $delete = $service->delete();

        if($delete) {
            return response()->json([
                'status' => 201,
                'message' => 'Delete Successfully'
            ]);
        }
    }

    private function checkAvailableService($type) {
        // get the data of user
        $user_model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $user_model::where('user_id', session()->get('id'))->with('package_checkout', 'user')->first();

        // Get the current purchased plan of user
        $purchased_plan_model = session()->get('role') == 'freelancer' ? FreelancePackage::class : EmployerPackage::class;
        $purchased_plan = $purchased_plan_model::where('id', $user->package_checkout->package_type)->first();

        // Get the current created services of user
        $current_user_services = Service::where('freelancer_id', $user->id)->where('expiration_date', $user->package_date_expiration)->count();
        $current_user_featured_services = Service::where('freelancer_id', $user->id)->where('expiration_date', $user->package_date_expiration)->where('type', 'featured')->count();

        if($current_user_services == $purchased_plan->total_services) return true;

        if($type == 'featured') {
            if($current_user_featured_services == $purchased_plan->total_feature_services) return true;
        }

        return false;
    }

    public function admin_index() {
        return view("AdminScreens.services.services");
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 403);
        $data = Service::select('*')->with('freelancer', 'category')->where('expiration_date', '>=', Carbon::now());
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('service_category', function($row) {
                    return $row->category->name;
                })
                ->addColumn('type', function($row) {
                    if($row->type == 'featured') {
                        return '<div class="badge badge-success">'.$row->type.'</div>';
                    }
                    return '<div class="badge badge-secondary">'.$row->type.'</div>';
                })
                ->addColumn('freelancer', function($row) {
                    return $row->freelancer->user->firstname . " " . $row->freelancer->user->lastname;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="/admin/services/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'type'])
                ->toJson();
    }

    public function admin_edit(Request $request) {
        $categories = ServiceCategory::all();
        $service = Service::where('id', $request->id)->with('freelancer')->first();
        $service_images = json_decode($service->attachments);
        return view('AdminScreens.services.edit-service', compact('service', 'categories', 'service_images'));
    }
}