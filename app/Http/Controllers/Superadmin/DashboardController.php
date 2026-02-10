<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;

class DashboardController
{
    public function index(Request $request)
    {
        return view('superadmin.dashboard');
    }
}
