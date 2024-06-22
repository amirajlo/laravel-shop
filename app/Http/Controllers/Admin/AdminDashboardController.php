<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

class AdminDashboardController extends MainController
{
    public function dashboard(){
        return view('admin.dashboard');
    }
}
