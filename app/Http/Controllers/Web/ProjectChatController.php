<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectMessage;
use App\Models\Freelancer;
use App\Models\Employer;

use App\Events\ProjectMessageEvent;
use App\Events\ChatTypingEvent;

class ProjectChatController extends Controller
{
    public function project_get_chat(Request $request) {
        $type = $request->type;
        $messages = ProjectMessage::where('msg_id', $request->id)->where('message_type', $type)->get();
        $user_model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $user_model::where('user_id', session()->get('id'))->first();
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

    public function send_project_chat(Request $request) {

        $save = ProjectMessage::create([
            'incoming_msg_id' => $request->incoming_id,
            'outgoing_msg_id' => $request->outgoing_id,
            'msg_id' => $request->msg_id,
            'message_type' => $request->type,
            'message' => $request->message,
            'role' => session()->get('role')
        ]);

        $receiver_user_id = (int) $request->receiver_user_id;

        $message_status = session()->get('id') != $receiver_user_id ? 'incoming' : 'outgoing';

        $message_data = [
            'outgoing_msg_id' => $request->outgoing_id,
            'status' => $message_status,
            'message' => $request->message
        ];

        event(new ProjectMessageEvent($message_data, $receiver_user_id));
        return response()->json([
            'status' => 201,
            'message' => 'Message Successfully Sent'
        ]);
    }

    public function chat_typing(Request $request) {
        event(new ProjectMessageEvent(true, $receiver_user_id));
    }

    public function stop_chat_typing(Request $request) {
        event(new ProjectMessageEvent(false, $receiver_user_id));
    }
}
