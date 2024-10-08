<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\amphures;
use App\Models\districts;
use App\Models\provinces;

class UserController extends Controller
{
    public function user()
    {
        $data['usersSell'] = DB::table('users')
                    ->where('is_delete', 0)
                    ->where('type', '=', 0)
                    ->get();

        $data['usersBuy'] = DB::table('users')
                    ->where('is_delete', 0)
                    ->where('type', '=', 1)
                    ->get();

        return view('admin.User.list', $data);
    }

    public function createuser()
    {
        return view('admin.User.create');
    }

    public function createSave(Request $request)
    {

        // ตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $request->validate([
            'name_lasname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|in:ผู้ซื้อ,ผู้ขาย,Admin',
        ], [
            'name_lasname.required' => 'กรุณากรอกชื่อ-สกุล',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกอีเมลให้ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีผู้ใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'type.required' => 'กรุณาเลือกประเภทผู้ใช้',
            'type.in' => 'ประเภทผู้ใช้ไม่ถูกต้อง',
        ]);

        // สร้างผู้ใช้ใหม่ หรือประมวลผลข้อมูลตามที่ต้องการ
        $users = new User;
        $users->name_lasname = trim($request->name_lasname);
        $users->email = trim($request->email);
        $users->password = Hash::make($request->password);
        $users->type = trim($request->type);
        $users->save();


        return redirect('/user');
    }

    public function deleteuser($id)
    {

        $users = User::getSingle($id);
        $users->is_delete = 1;
        $users->save();

        return redirect('/user');
    }

    public function getAmphures(Request $request)
    {
        $provinceId = $request->input('province_id');
        $amphures = amphures::where('province_id', $provinceId)->get();

        return response()->json($amphures);
    }

    public function getDistricts(Request $request)
    {
        $amphureId = $request->input('amphure_id');
        $districts = districts::where('amphure_id', $amphureId)->get();

        return response()->json($districts);
    }

    public function getZipCode(Request $request)
    {
        $districtId = $request->input('district_id');
        $districts = districts::find($districtId);
        return response()->json($districts->zip_code);
    }

}
