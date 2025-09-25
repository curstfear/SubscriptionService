<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Section;
use App\Models\Plan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $sectionCount = Section::count();
        $planCount = Plan::count();
        return view("admin.index", compact("userCount", "sectionCount", "planCount"));
    }
}
