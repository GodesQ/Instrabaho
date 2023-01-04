<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectMessage;
use App\Models\Freelancer;
use App\Models\Employer;

class ProjectChatController extends Controller
{
    public function project_get_chat(Request $request) {
        $type = base64_decode($request->type);
        $messages = ProjectMessage::where('msg_id', $request->id)->where('message_type', $type)->get();
        $user_model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $user_model::where('user_id', session()->get('id'))->first();
        $output = "";
        if($messages->count() > 0) {
            foreach($messages as $message) {
                if($message->outgoing_msg_id === $user->id && $message->role == session()->get('role')){
                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>'. $message->message .'</p>
                                    </div>
                                </div>';
                } else{
                    $output .= '<div class="chat incoming">
                                    <div class="details">
                                        <p>'. $message->message .'</p>
                                    </div>
                                </div>';
                }
            }
        }
        echo $output;
    }

    public function send_project_chat(Request $request) {
        $save = ProjectMessage::create([
            'incoming_msg_id' => $request->incoming_id,
            'outgoing_msg_id' => $request->outgoing_id,
            'msg_id' => $request->msg_id,
            'message_type' => base64_decode($request->type),
            'message' => $request->message,
            'role' => session()->get('role')
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Message Successfully Sent'
        ]);
    }
}
