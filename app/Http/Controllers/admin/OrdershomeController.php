<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;
use App\Models\PriceModel;

class OrdershomeController extends Controller
{
    public function order_home()
    {
        return view('admin.Ordershome.list_order' );
    }

    public function order_home_create()
    {
        $data['getRecord'] = ProductModel::getRecord();
        return view('admin.Ordershome.create_order', $data );
    }

    public function order_create_save(Request $request)
    {

        // บันทึกข้อมูลผู้ซื้อ
        $userbuy = new UserBuyModel;
        $userbuy->name = trim($request->name);
        $userbuy->last_name = trim($request->last_name);
        $userbuy->phone = trim($request->phone);
        $userbuy->quantity = $request->qty;
        $userbuy->save();


        $oderbuy = new OderBuyModel;
        $oderbuy->user_buy_id = $userbuy->id; // เชื่อมโยงคำสั่งซื้อกับข้อมูลผู้ซื้อ
        $oderbuy->product_id = $request->product_id; // สมมติว่าคุณส่ง product_id มาจากฟอร์ม
        $oderbuy->grade = $request->grade; // สมมติว่าคุณส่งเกรดสินค้า
        $oderbuy->price = $request->price; // สมมติว่าคุณส่งราคา\
        $oderbuy->quantity = $request->qty;
        $oderbuy->save();

        $oderbuy = PriceModel::where('product_id', $request->product_id)
            ->where('grade', $request->grade)
            ->first();

        if ($oderbuy) { // ตรวจสอบว่าพบผู้ใช้หรือไม่
            $oderbuy->qty += trim($request->qty);
            $oderbuy->save(); // บันทึกการเปลี่ยนแปลง
        }

        // เก็บข้อมูลใน session เพื่อส่งกลับไปยังฟอร์ม
        session()->put('name', $request->name);
        session()->put('last_name', $request->last_name);
        session()->put('phone', $request->phone);


        // ทำการบันทึกหรือส่งข้อมูลกลับหลังจากทำงานเสร็จ
        return redirect()->back()->with('successd', 'คำสั่งซื้อของคุณถูกบันทึกเรียบร้อยแล้ว!');
    }
}
