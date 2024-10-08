<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        $this->middleware('admin');
        return view('admin.dashboard');
    }

    public function userbuyHome()
    {
        $data['getProducts'] = ProductModel::getRecordAtive();
        $this->middleware('user');
        return view('welcome', $data);
    }

    public function sellerHome()
    {
        $data['getProducts'] = ProductModel::getRecordAtive();
        $this->middleware('user');
        return view('welcome', $data);
        
    }

    public function contact()
    {
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }
}
