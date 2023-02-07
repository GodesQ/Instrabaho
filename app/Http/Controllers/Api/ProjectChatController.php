<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectMessage;
use App\Models\Freelancer;
use App\Models\Employer;

class ProjectChatController extends Controller
{
    public function project_get_chat(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => false, 'message' => 'Forbidden'], 403);

        $type = $request->type;
        $messages = ProjectMessage::where('msg_id', $request->id)->where('message_type', $type)->get();

        $user_model = $role == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $user_model::where('user_id', $user_id)->first();

        // initial messages
        $output = [];

        if($messages->count() > 0) {
            foreach($messages as $message_data) {
                if($message_data->outgoing_msg_id === $user->id){
                    $message_output = ['outgoing_msg_id' => $message_data->outgoing_msg_id, 'status' => 'outgoing', 'message' => $message_data->message];
                    array_push($output, $message_output);
                } else {
                    $message_output = ['outgoing_msg_id' => $message_data->outgoing_msg_id, 'status' => 'incoming', 'message' => $message_data->message];
                    array_push($output, $message_output);
                }
            }
        }
        return response()->json($output, 200);
    }
}
