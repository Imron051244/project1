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

    public function category()
    {
        return view('admin.Category.listcategory');
    }

    public function product()
    {
        return view('admin.Product.listpdt');
    }

    public function price()
    {
        return view('admin.Price.list');
    }

    public function orders()
    {
        return view('admin.Orders.listOD');
    }

   
}


