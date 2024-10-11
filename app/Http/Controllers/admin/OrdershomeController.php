<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;
use App\Models\PriceModel;
use App\Models\BuyhomeModel;
use App\Models\Buy_dhomeModel;




class OrdershomeController extends Controller
{
    public function order_home()
    {
        $data['getRecord'] = BuyhomeModel::getRecord();
        
        return view('admin.Ordershome.list_order', $data);
    }

    public function order_home_create()
    {
        $data['getRecord'] = ProductModel::getRecord();
        return view('admin.Ordershome.create_order', $data);
    }

    public function order_create_save(Request $request)
    {
        // บันทึกข้อมูลผู้ซื้อ
        $buy_home = new BuyhomeModel;
        $buy_home->name = trim($request->name);
        $buy_home->last_name = trim($request->last_name);
        $buy_home->phone = trim($request->phone);
        $buy_home->save();

            // บันทึกข้อมูล ส่งมาจากฟอร์มหรือไม่
            foreach ($request->grade as $index => $grade) {
                // ตรวจสอบข้อมูลทีละรายการในลูป
                $buy_d = new Buy_dhomeModel;
                $buy_d->buy_home_id = $buy_home->id; // เชื่อมโยงกับข้อมูลผู้ซื้อ
                $buy_d->product_id = $request->product_id; // สมมติว่ามี product_id มาจากฟอร์ม
                $buy_d->grade = $grade;
                $buy_d->price = $request->price[$index]; //การเปลียน array เป็น string
                $buy_d->qty_buy = $request->qty[$index];

                // คำนวณราคาทั้งหมด
                $buy_d->price_total = $buy_d->price * $buy_d->qty_buy;
                $buy_d->save(); 

                // บันทึกสินค้าในคลังสินค้า
                $buy_d = PriceModel::where('product_id', $request->product_id)
                    ->where('grade', $request->grade)
                    ->first();

                if ($buy_d) {
                    $buy_d->qty += $request->qty[$index];
                    $buy_d->save();
                }
            }
        

        

        // ส่งกลับไปยังฟอร์มพร้อมข้อความสำเร็จ
        return redirect('/orders-home')->with('successd', 'คำสั่งซื้อของคุณถูกบันทึกเรียบร้อยแล้ว!');
    }
}
