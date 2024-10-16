<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;
use App\Models\ProductModel;
use App\Models\PriceModel;
use App\Models\OderBuy_dModel;




class OrdersbuyController extends Controller
{

    public function list_order_buy()
    {
        $data['getbuy'] = UserBuyModel::getRecord();
        return view('admin.Ordersbuy.list_buy', $data);
    }
    public function detail_order_buy($id)
    {
        $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        $data['getSingle'] = UserBuyModel::getSingle($id);

        return view('admin.Ordersbuy.detail_buy', $data);
    }

    public function grade_price(Request $request)
    {
        $grade = $request->input('grade');

        // ดึงข้อมูลราคาตาม product_id และ grade
        $price = PriceModel::where('grade', $grade)->first();
        return response()->json($price->price_buy);
    }

    public function create_order_buy($id)
    {

        $data['getRecord'] = ProductModel::getRecord();
        $data['getSingle'] = UserBuyModel::getSingle($id);
        return view('admin.Ordersbuy.order_buy_create', $data);
    }

    public function create_order_save($id, Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required',          // ตรวจสอบว่า qty เป็น array
        ], [
            'product_id.required' => 'กรุณาเลือกสินค้า',
            'qty.required' => 'กรุณากรอกจำนวน',
        ]);

        $buy_d = UserBuyModel::getSingle($id);

        $buy_d_d = new OderBuyModel;
        $buy_d_d->user_buy_id = $buy_d->id; // เชื่อมโยงกับข้อมูลผู้ซื้อ
        $buy_d_d->product_id = $request->product_id; // สมมติว่ามี product_id มาจากฟอร์ม
        $buy_d_d->quantity = $request->qty;
        $buy_d_d->save();

        return redirect("/orders-buy/detail/{$id}")->with('successa', 'เพิ่มสินค้าการขายสำเร็จ!');
    }

    public function edit_order_buy($id)
    {
        $data['getProductPrices'] = ProductModel::getPrices($id);
        $data['getSingle'] = OderBuyModel::getSingle_edit($id);

        return view('admin.Ordersbuy.edit_buy', $data);
    }

    public function edit_save_buy($id, Request $request)
    {
        // บันทึกข้อมูลผู้ซื้อ
        $buy_d = OderBuyModel::getSingle_edit($id);

        // บันทึกข้อมูล ส่งมาจากฟอร์มหรือไม่
        foreach ($request->grade as $index => $grade) {
            // ตรวจสอบข้อมูลทีละรายการในลูป
            $buy_d_d = OderBuy_dModel::where('buy_d_id', $buy_d->id)
                ->where('product_id', $buy_d->product_id) // เชื่อมโยงกับข้อมูลผู้ซื้อ 
                ->where('grade', $grade) // ตรวจสอบเกรดเดียวกัน
                ->first();

            if ($buy_d_d) {
                // ถ้ามีข้อมูลอยู่แล้ว อัปเดตปริมาณ
                $buy_d_d->qty_buy += $request->qty[$index];
                // คำนวณราคาทั้งหมดใหม่
                $buy_d_d->price_total = $buy_d_d->price * $buy_d_d->qty_buy;
                $buy_d_d->save();
            } else {
                // ถ้าไม่มีข้อมูล ให้สร้างข้อมูลใหม่
                $buy_d_d = new OderBuy_dModel;
                $buy_d_d->buy_d_id = $buy_d->id;
                $buy_d_d->product_id = $buy_d->product_id; // เชื่อมโยงกับข้อมูลผู้ซื้อ 
                $buy_d_d->grade = $grade;
                $buy_d_d->price = $request->price[$index]; //การเปลียน array เป็น string
                $buy_d_d->qty_buy = $request->qty[$index];

                // คำนวณราคาทั้งหมด
                $buy_d_d->price_total = $buy_d_d->price * $buy_d_d->qty_buy;
                $buy_d_d->save();
            }

            // บันทึกสินค้าในคลังสินค้า
            $inventory = PriceModel::where('product_id', $request->product_id)
                ->where('grade', $grade) // ใช้เกรดจากลูป
                ->first();

            if ($inventory) {
                $inventory->qty += $request->qty[$index];
                $inventory->save();
            }
        }

        return redirect("/orders-buy/detail/detail-product/{$id}")->with('successa', 'อัปเดตข้อมูลการขายสำเร็จ!');
    }


    public function detail_e_buy($id)
    {
        $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        $data['getSinglebuy'] = OderBuyModel::getSingle_edit($id);


        return view('admin.Ordersbuy.detail_e_buy', $data);
    }

    public function edit_e_buy($id)
    {
        $data['getSingle'] = OderBuy_dModel::getSingle($id);

        return view('admin.Ordersbuy.edit_e_buy', $data);
    }

    public function edit_e_save($id, Request $request)
    {
        // ค้นหา Order Detail โดย ID
        $buy_d_d = OderBuy_dModel::getSingle($id);

        // กำหนดค่าจากฟอร์ม
        $buy_d_d->product_id = trim($request->product_id);
        $buy_d_d->grade = trim($request->grade);
        $buy_d_d->price = trim($request->price);
        $buy_d_d->qty_buy = trim($request->qty);

        // คำนวณราคาทั้งหมด
        $buy_d_d->price_total = $buy_d_d->price * $buy_d_d->qty_buy;
        $buy_d_d->save();

        // อัปเดตสินค้าคงคลัง
        $inventory = PriceModel::where('product_id', $request->product_id)
            ->where('grade', $request->grade)
            ->first();

        if ($inventory) {
            $inventory->qty += $request->qty; // เพิ่มจำนวนสินค้าในคลัง
            $inventory->save();
        }

        return redirect()->back()->with('successa', 'อัปเดตข้อมูลการขายสำเร็จ!');
    }

    public function update_status_buy(Request $request, $id)
    {
        // ดึงข้อมูลคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel
        $Orderhome = UserBuyModel::find($id);

        $status = $request->input('status');

        // เปลี่ยนสถานะใหม่
        $Orderhome->status = $status;

        // บันทึกการเปลี่ยนแปลง
        $Orderhome->save();

        // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
        return redirect()->back();
    }

    public function status_e_buy(Request $request, $id)
    {
        // ดึงข้อมูลคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel
        $Orderhome = OderBuyModel::find($id);

        $status = $request->input('status');

        // เปลี่ยนสถานะใหม่
        $Orderhome->status = $status;

        // บันทึกการเปลี่ยนแปลง
        $Orderhome->save();

        // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
        return redirect()->back();
    }

    public function showReceipt_buy($id)
    {
        // $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        // $data['getSingle'] = UserBuyModel::getSingle($id);
        $data['getSinglebuy'] = OderBuyModel::getSingle_edit($id);

        return view('admin.Ordersbuy.receipt', $data);
    }
}
