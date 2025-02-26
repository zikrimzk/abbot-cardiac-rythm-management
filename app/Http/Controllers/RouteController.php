<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    // Login Route 
    public function loginpage(){
        return view('crmd-system.login-page',[
            'title'=>'CRMD System | Login'
        ]);
    }

    // Staff Dashboard Route
    public function staffDashboard(){
        return view('crmd-system.staff.staff-dashboard',[
            'title'=>'CRMD System | Staff Dashboard'
        ]);
    }

    // Manage Department Route
    public function manageDepartment(){
        return view('crmd-system.staff-management.manage-department',[
            'title'=>'CRMD System | Manage Department'
        ]);
    }
}
