<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\amphures;
use App\Models\districts;
use App\Models\provinces;

class IndexController extends Controller
{

    public function index() {
        
        $provinces = provinces::all();
        return view('index', compact('provinces'));
    }

    public function getAmphures(Request $request) {
        $provinceId = $request->input('province_id');
        $amphures = amphures::where('province_id', $provinceId)->get();

        return response()->json($amphures);
    }

    public function getDistricts(Request $request) {
        $amphureId = $request->input('amphure_id');
        $districts = districts::where('amphure_id', $amphureId)->get();

        return response()->json($districts);
    }
}
