<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserPermission;

class UserPermissionController extends Controller
{
    public function permission(Request $request) {
        return view('AdminScreens.user_permission.user_permission');
    }
}