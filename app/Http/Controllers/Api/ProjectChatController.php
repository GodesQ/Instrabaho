<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectChatController extends Controller
{
    public function project_get_chat(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => false, 'message' => 'Forbidden'], 403);

        $type = base64_decode($request->type);
        $messages = ProjectMessage::where('msg_id', $request->id)->where('message_type', $type)->get();

        $user_model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $user_model::where('user_id', session()->get('id'))->first();

        // initial messages
        $output = [];

        if($messages->count() > 0) {
            foreach($messages as $message) {
                if($message->outgoing_msg_id === $user->id && $message->role == session()->get('role')){
                    $message_output = ['status' => 'outgoing', $message->message];
                    array_push($output, $message_output);
                } else{
                    $message_output = ['status' => 'incoming', $message->message];
                    array_push($output, $message_output);
                }
            }
        }

        return response()->json($output, 200);
    }
}
