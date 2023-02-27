<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\ProjectMessage;
use DB;

class ChatController extends Controller
{
    public function chats() {
        return view('UserAuthScreens.chats.chat_box');
    }

    public function get_users(Request $request) {
        abort_if(!$request->ajax(), 404);

        $chat_type = $request->chat_type;
        $role = session()->get('role');
        $user_id = session()->get('id');

        if($role === 'freelancer') {
            $user_role_data = Freelancer::where('user_id', $user_id)->with('user')->first();
        }

        if($role === 'employer') {
            $user_role_data = Employer::where('user_id', $user_id)->with('user')->first();
        }

        $user_chats = ProjectMessage::select('msg_id',
            DB::raw('MAX(id) as id'),
            DB::raw('MAX(outgoing_msg_id) as outgoing_msg_id'),
            DB::raw('MAX(incoming_msg_id) as incoming_msg_id'),
            DB::raw('MAX(message) as message'),
            DB::raw('MAX(message_type) as message_type'),
            DB::raw('MAX(created_at) as created_at'),
            DB::raw('MAX(updated_at) as updated_at'))
            ->where('outgoing_msg_id', $user_role_data->id)
            ->where('role', $role)
            ->groupBy('msg_id')
            ->latest('id')
            ->get();

        return response()->json($user_chats);
    }
}
