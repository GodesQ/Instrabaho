<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Employer;

class ChatController extends Controller
{
    public function chats() {
        return view('UserAuthScreens.chats.chat_box');
    }

    public function get_chats(Request $request) {

    }
}
