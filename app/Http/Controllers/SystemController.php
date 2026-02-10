<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Functionality;

class SystemController
{
    public function index(Request $request)
    {
        return view('system');
    }
}
