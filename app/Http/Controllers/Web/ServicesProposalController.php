<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Addon;
use App\Models\ServicesProposal;
use App\Models\Employer;
use App\Models\Freelancer;
use Yajra\DataTables\Facades\DataTables;

class ServicesProposalController extends Controller
{   
    public function submit_proposal(Request $request) {
        $request->validate([
            'estimated_date' => 'required',
            'message' => 'required',
            'location' => 'required'
        ]);

        $service_addons_total = 0;
        if(isset($request->services_addon)) {
            $service_addons_total = Addon::find($request->services_addon)->sum('price');
        }

        $buyer = Employer::where('user_id', session()->get('id'))->first();
        if(!$buyer) {
            return back()->with('fail', "Sorry. Please create first an employer's account before sending a service proposal.");
        }
        
        $save = ServicesProposal::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $request->seller_id,
            'service_id' => $request->service_id,
            'addon_ids' => isset($request->services_addon) ? json_encode($request->services_addon) : null,
            'estimated_date' => $request->estimated_date,
            'message' => $request->message,
            'location' => $request->location,
            'sub_total' => $request->service_cost,
            'total' => $request->service_cost + $service_addons_total,
            'status' => 'pending',
            'isCancel' => false,
        ]);

        return back()->with('success', 'Approval Sent Successfully');
    }   
    
    public function change_status(Request $request) {
        
        if(!$request->purchased_services) {
            return back()->with('fail', 'Select atleast one service to update.');
        }

        if($request->action == 'cancel') {
            $updateService = ServicesProposal::whereIn('id', $request->purchased_services)
              ->update(['isCancel' => true])
              ->update(['status' => $request->action]); 
        } else {
            $updateService = ServicesProposal::whereIn('id', $request->purchased_services)
              ->update(['status' => $request->action]);
        }

        return redirect('/purchased_service/ongoing')->with('success', 'Update Successfully');
    }

    public function pending(Request $request) {
        $query = $request->input('query');
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        
        $purchased_services = ServicesProposal::where('seller_id', $freelancer->id)
        ->where('status', 'pending')
        ->where('isCancel', 0)
        ->with('service', 'employer')
        ->cursorPaginate(10);
        return view('UserAuthScreens.services_proposals.pending_services', compact('purchased_services'));
    }

    // public function ongoing(Request $request) {
    //     $query = $request->input('query');
    //     $purchased_services = $this->fetchPurchasedServices('approved');
    //     return view('UserAuthScreens.services_proposals.ongoing_services', compact('purchased_services'));
    // }

    public function approved() {
        return view('UserAuthScreens.services_proposals.approved_services');
    } 

    public function get_approved_services(Request $request) {
        if ($request->ajax()) {
            $user_id = session()->get('id');
            $role = session()->get('role');
            $user = $role == 'freelancer' ? Freelancer::where('user_id', $user_id)->first() : Employer::where('user_id', $user_id)->first();
            $data = ServicesProposal::where('isCancel', 0)->where(function($query) use ($role, $user) {
                if($role == 'freelancer') {
                    $query->where('seller_id', $user->id);
                } else{
                    $query->where('buyer_id', $user->id);
                }
            })->where('status', '!=', 'pending')->with('service', 'employer', 'freelancer');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('service', function($row){
                        return $row->service->name;
                    })
                    ->addColumn('user', function($row){
                        if(session()->get('role') == 'employer') {
                            return $row->freelancer->display_name;
                        }
                        return $row->employer->display_name;
                    })
                    ->addColumn('category', function($row){
                        return $row->service->category->name;
                    })
                    ->addColumn('cost', function($row){
                        return number_format($row->total, 2);
                    })
                    ->addColumn('status', function($row){     
                        $status = "<div class='badge badge-info'>$row->status</div>";
                        return $status;
                    })
                    ->addColumn('action', function($row){     
                        $btn = '<a href="/service_proposal_information/'. $row->id .'" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Cancel Service</a>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->toJson();
        }
    }

    // public function completed(Request $request) {
    //     $query = $request->input('query');
    //     $purchased_services = $this->fetchPurchasedServices('completed');
    //     return view('UserAuthScreens.services_proposals.completed_services', compact('purchased_services'));
    // }

    // public function fetchPurchasedServices($status) {
    //     if(session()->get('role') == 'freelancer') {
    //         $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
    //         $purchased_services = ServicesProposal::where('seller_id', $freelancer->id)
    //         ->where('status', $status)
    //         ->where('isCancel', 0)
    //         ->with('service', 'employer')
    //         ->cursorPaginate(10);
    //     } else {
    //         $employer = Employer::where('user_id', session()->get('id'))->first();
    //         $purchased_services = ServicesProposal::where('buyer_id', $employer->id)
    //         ->where('status', $status)
    //         ->where('isCancel', 0)
    //         ->with('service', 'employer')
    //         ->cursorPaginate(10);
    //     }
    //     return $purchased_services;
    // }

    public function service_proposal_information(Request $request) {
        $purchased_service = ServicesProposal::where('id', $request->id)->with('freelancer', 'service', 'employer')->first();
        $user_model = session()->get('role') == 'freelancer' ? Employer::class : Freelancer::class;
        
        if(session()->get('role') == 'freelancer') {
            $receiver = $user_model::where('id', $purchased_service->buyer_id)->with('user')->first();
        } else {
            $receiver = $user_model::where('id', $purchased_service->seller_id)->with('user')->first();
        }
        $incoming_msg_id = session()->get('role') == 'freelancer' ? $purchased_service->buyer_id : $purchased_service->seller_id;
        $outgoing_msg_id = session()->get('role') == 'freelancer' ? $purchased_service->seller_id : $purchased_service->buyer_id;
        return view('UserAuthScreens.services_proposals.view_service', compact('purchased_service', 'incoming_msg_id', 'outgoing_msg_id', 'receiver'));
    }
    


}