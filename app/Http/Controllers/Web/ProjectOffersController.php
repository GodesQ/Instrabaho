<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectOffer;
use App\Models\Employer;
use App\Models\Freelancer;

class ProjectOffersController extends Controller
{
    //
    public function employer_create_offer(Request $request) {
        $user_id = session()->get('id');
        $employer = Employer::where('user_id', $user_id)->with('projects')->firstOrFail();
        $freelancer = Freelancer::where('display_name', $request->freelancer)->firstOrFail();

        return view('UserAuthScreens.projects_offers.create-offer', compact('employer', 'freelancer'));
    }

    public function store(Request $request) {
        dd($request->all());
    }

    public function freelancer_view_offer() {

    }
    
}
