<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    
    public function deshboard()
    {
        return view('admin.dashboard');
    }

   
}


