<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;


class AdminDashboardController extends MainController
{
    public function dashboard(){
        return view('admin.dashboard');
    }
}
