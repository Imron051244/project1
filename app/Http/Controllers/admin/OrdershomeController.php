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
        return view('admin.Ordershome.list_order');
    }

    public function order_home_create()
    {
        $data['getRecord'] = ProductModel::getRecord();
        return view('admin.Ordershome.create_order', $data);
    }

    public function order_create_save(Request $request)
    {
        dd($request->all());
        // บันทึกข้อมูลผู้ซื้อ
        $buy_home = new BuyhomeModel;
        $buy_home->name = trim($request->name);
        $buy_home->last_name = trim($request->last_name);
        $buy_home->phone = trim($request->phone);
        $buy_home->save();


        $buy_d = new Buy_dhomeModel;
        $buy_d->buy_home_id = $buy_home->id; // เชื่อมโยงคำสั่งซื้อกับข้อมูลผู้ซื้อ
        $buy_d->product_id = $request->product_id; // สมมติว่าคุณส่ง product_id มาจากฟอร์ม
        $buy_d->grade = trim($request->grade); // สมมติว่าคุณส่งเกรดสินค้า
        $buy_d->price = trim($request->price); // สมมติว่าคุณส่งราคา\
        $buy_d->qty_buy = trim($request->qty);
        $buy_d->price_total = $request->price * $request->qty;
        $buy_d->save();

        $buy_d = PriceModel::where('product_id', $request->product_id)
            ->where('grade', $request->grade)
            ->first();

        if ($buy_d) { // ตรวจสอบว่าพบผู้ใช้หรือไม่
            $buy_d->qty += trim($request->qty);
            $buy_d->save(); // บันทึกการเปลี่ยนแปลง
        }

        // เก็บข้อมูลใน session เพื่อส่งกลับไปยังฟอร์ม
        session()->put('name', $request->name);
        session()->put('last_name', $request->last_name);
        session()->put('phone', $request->phone);

        // ทำการบันทึกหรือส่งข้อมูลกลับหลังจากทำงานเสร็จ
        return redirect()->back()->with('successd', 'คำสั่งซื้อของคุณถูกบันทึกเรียบร้อยแล้ว!');
    }
}
