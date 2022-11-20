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
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ServicesController extends Controller
{
    public function index() {
        $user_id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        $services = Service::where('freelancer_id', $freelancer->id)->where('expiration_date', '>=' , Carbon::now())->latest('id')->where('isDeleted', 0)->cursorPaginate(10);
        return view('UserAuthScreens.services.services', compact('services'));
    }

    public function create() {
        $categories = ServiceCategory::all();
        return view('UserAuthScreens.services.create-service', compact('categories'));
    }

    public function store(StoreServiceRequest $request) {
        if(session()->get('role') == 'freelancer') {
            //check if the current plan is exceed in limit
            if($this->checkAvailableService($request->type)) return back()->with('fail', 'Sorry but your current plan exceed the limit. Wait for expiration then buy again');
        }

        $user_type = base64_decode($request->user_type);
        $images = [];
        foreach ($request->file('attachment') as $key => $attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path().'/images/services', $image_name);
            array_push($images, $image_name);
        }
        $json_images = json_encode($images);
        $user_id = session()->get('id');
        $freelancer_query = Freelancer::query();

        if($user_type == 'admin') {
            $freelancer =  $freelancer_query->where('id', $request->freelancer)->first();
        } else {
            $freelancer = $freelancer_query->where('user_id', $user_id)->first();
        }

        $save = Service::create(array_merge($request->validated(), [
            'freelancer_id' => $freelancer->id,
            'attachments' => $json_images,
            'expiration_date' => $freelancer->package_date_expiration
        ]));

        if($user_type == 'admin') return redirect()->route('admin.services')->with('success', 'Successfully Created');
        return redirect('/freelancer/services')->with('success', 'Service Added Successfully');
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

    public function update(UpdateServiceRequest $request) {

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
        $update = $service->update(array_merge($request->validated(), [
            'attachments' => $json_images,
        ]));
        if($update) {
            return back()->with('success', 'Update Successfully');
        }
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

        $service->attachments = [];
        $service->isDeleted = 1;
        $delete = $service->save();

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
        $data = Service::select('*')->with('freelancer', 'category')->where('expiration_date', '>=', Carbon::now())->where('isDeleted', 0);
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
                            <a id="'. $row->id .'" class="delete-service datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
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

    public function admin_create(Request $request) {
        $categories = ServiceCategory::all();
        return view('AdminScreens.services.create-service', compact('categories'));
    }

}