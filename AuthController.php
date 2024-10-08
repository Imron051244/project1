<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registerSave(Request $request)
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
        // เช่น การบันทึกข้อมูลลงในฐานข้อมูล
        User::create([
            'name_lasname' => $request->name_lasname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type
        ]);

        return redirect()->route('login');
    }

    public function loginAction(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'กรุณากรอกอีเมล',
                'email.email' => 'กรุณากรอกอีเมลให้ถูกต้อง',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
            ]

        );

        $credentials = $request->only('email', 'password');

        // ตรวจสอบว่ามีอีเมลนี้ในระบบหรือไม่
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // ไม่มีอีเมลนี้ในระบบ
            throw ValidationException::withMessages([
                'email' => 'อีเมลยังไม่ได้สมัครสมาชิก.',
            ]);
        }

        // พยายามเข้าสู่ระบบด้วยข้อมูลที่รับเข้ามา
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // เข้าสู่ระบบสำเร็จ
            $request->session()->regenerate();

            // ตรวจสอบประเภทผู้ใช้งาน
            switch (auth()->user()->type) {
                case 'ผู้ซื้อ':
                    return redirect()->route('userbuy.home');
                case 'ผู้ขาย':
                    return redirect()->route('seller.home');
                case 'Admin':
                    return redirect()->route('admin.home');
            }
        } else {
            // รหัสผ่านไม่ถูกต้อง
            throw ValidationException::withMessages([
                'password' => 'รหัสผ่านไม่ถูกต้อง.',
            ]);
        }
    }
}
