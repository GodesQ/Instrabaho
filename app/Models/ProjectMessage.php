<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMessage extends Model
{
    use HasFactory;
    protected $table = 'project_messages';
    protected $guarded = [];

    protected $appends = ['incoming_user', 'outgoing_user', 'message_type_data'];

    public function getIncomingUserAttribute() {
        if(session()->get('role') == 'freelancer') {
            $user = Employer::where('id', $this->incoming_msg_id)->with('user')->first();
        }

        if(session()->get('role') == 'employer') {
            $user = Freelancer::where('id', $this->incoming_msg_id)->with('user')->first();

        }

        return $user;
    }

    public function getOutgoingUserAttribute() {
        if(session()->get('role') == 'freelancer') {
            $user = Freelancer::where('id', $this->outgoing_msg_id)->with('user')->first();
        }

        if(session()->get('role') == 'employer') {
            $user = Employer::where('id', $this->outgoing_msg_id)->with('user')->first();
        }
        return $user;
    }

    public function getMessageTypeDataAttribute() {
        if($this->message_type == 'proposal') {
            $data = ProjectProposal::where('id', $this->msg_id)->with('project')->first();
        }

        if($this->message_type == 'offer') {
            $data = ProjectOffer::where('id', $this->msg_id)->with('project')->first();
        }
        return $data;
    }
}
