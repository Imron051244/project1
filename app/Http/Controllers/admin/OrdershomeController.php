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

        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|digits:10',
            'product_id' => 'required',
            'grade' => 'required|array',        // ตรวจสอบว่า grade เป็น array
            'grade.*' => 'required',            // ตรวจสอบว่าแต่ละรายการใน array มีค่า
            'qty' => 'required',          // ตรวจสอบว่า qty เป็น array
        ], [
            'name.required' => 'กรุณากรอกชื่อ',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'phone.required' => 'กรุณากรอกหมายเลขโทรศัพท์',
            'phone.digits' => 'กรุณากรอกหมายเลขโทรศัพท์ให้ครบ 10 หลัก',
            'product_id.required' => 'กรุณาเลือกสินค้า',
            'grade.required' => 'กรุณาเลือกเกรดสินค้า',
            'grade.*.required' => 'กรุณาเลือกเกรดในแต่ละรายการ',
            'qty.required' => 'กรุณากรอกจำนวน',

        ]);


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


    public function order_detail_home($id)
    {
        $data['getdetail'] = BuyhomeModel::getdetail($id);
        return view('admin.Ordershome.detail_order', $data);
    }

    public function update_status_buyhome(Request $request, $id)
    {
        // ดึงข้อมูลคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel
        $Orderhome = BuyhomeModel::find($id);

        if ($Orderhome) {

            $status = $request->input('status');

            // เปลี่ยนสถานะใหม่
            $Orderhome->status = $status;

            // บันทึกการเปลี่ยนแปลง
            $Orderhome->save();

            // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
            return redirect()->back();
        } else {
        }
    }

    public function order_home_edit($id)
    {
        $data['getSingle'] = Buy_dhomeModel::getSingle($id);
        $data['getRecord'] = ProductModel::getRecord();
        return view('admin.Ordershome.edit_order', $data);
    }

    public function order_save_edit(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'grade' => 'required',
            'qty' => 'required|integer|min:1', // ตรวจสอบให้แน่ใจว่าจำนวนเป็นจำนวนเต็มและมากกว่าศูนย์
        ], [
            'product_id.required' => 'กรุณาเลือกสินค้า',
            'grade.required' => 'กรุณาเลือกเกรดสินค้า',
            'qty.required' => 'กรุณากรอกจำนวน',
        ]);

        // ดึงข้อมูลคำสั่งซื้อที่ต้องการอัพเดต
        $buy_d = Buy_dhomeModel::find($id);

        // เก็บข้อมูลเก่าก่อนอัพเดต
        $old_qty = $buy_d->qty_buy; // จำนวนเก่าที่มีอยู่
        $old_grade = $buy_d->grade; // เกรดเก่าที่มีอยู่

        // อัพเดตข้อมูลคำสั่งซื้อ
        $buy_d->product_id = trim($request->product_id);
        $buy_d->grade = trim($request->grade);
        $buy_d->price = trim($request->price);
        $buy_d->qty_buy = trim($request->qty);
        $buy_d->price_total = trim($request->price * $request->qty);
        $buy_d->save();

        // จัดการกับการอัพเดตสินค้าในคลัง
        $priceModel = PriceModel::where('product_id', $request->product_id)
            ->where('grade', $request->grade)
            ->first();

        // ถ้าเกรดมีการเปลี่ยนแปลงให้คืนค่าจำนวนเก่าก่อน
        if ($old_grade !== $request->grade) {
            // คืนค่าจำนวนเก่ากลับไปในคลัง
            $old_priceModel = PriceModel::where('product_id', $request->product_id)
                ->where('grade', $old_grade)
                ->first();

            if ($old_priceModel) {
                $old_priceModel->qty += $old_qty; // เพิ่มจำนวนเก่าเข้าไปในคลัง
                $old_priceModel->save();
            }
        }

        // อัพเดตคลังสินค้าสำหรับเกรดใหม่
        if ($priceModel) {
            $priceModel->qty -= $request->qty; // ลดจำนวนในคลังตามจำนวนที่ซื้อใหม่
            $priceModel->save();
        }

        // ส่งกลับไปยังฟอร์มพร้อมข้อความสำเร็จ
        return redirect("/orders-home")->with('successd', 'คำสั่งซื้อของคุณถูกอัพเดทเรียบร้อยแล้ว!');
    }


    public function order_e_create($id)
    {
        $data['getRecord'] = ProductModel::getRecord();
        $data['getSingle'] = BuyhomeModel::getSingle($id);
        return view('admin.Ordershome.order_e_create', $data);
    }


    public function order_e_save(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'grade' => 'required|array',        // ตรวจสอบว่า grade เป็น array
            'grade.*' => 'required',            // ตรวจสอบว่าแต่ละรายการใน array มีค่า
            'qty' => 'required|array',          // ตรวจสอบว่า qty เป็น array
        ], [
            'product_id.required' => 'กรุณาเลือกสินค้า',
            'grade.required' => 'กรุณาเลือกเกรดสินค้า',
            'grade.*.required' => 'กรุณาเลือกเกรดในแต่ละรายการ',
            'qty.required' => 'กรุณากรอกจำนวน',
        ]);

        // ดึงข้อมูลผู้ซื้อที่ต้องการอัพเดต
        $buy_home = BuyhomeModel::getSingle($id);

        // บันทึกข้อมูล ส่งมาจากฟอร์มหรือไม่
        foreach ($request->grade as $index => $grade) {
            // ตรวจสอบว่ามีรายการเกรดเดิมอยู่แล้วหรือไม่
            $existing_item = Buy_dhomeModel::where('buy_home_id', $buy_home->id)
                ->where('product_id', $request->product_id)
                ->where('grade', $grade)
                ->first();

            if ($existing_item) {
                // ถ้ามี ให้ทำการอัพเดตข้อมูล
                $existing_item->qty_buy += $request->qty[$index]; // อัพเดตจำนวน
                $existing_item->price_total = $existing_item->price * $existing_item->qty_buy; // คำนวณราคาทั้งหมด
                $existing_item->save();

                // บันทึกสินค้าในคลังสินค้า
                $priceModel = PriceModel::where('product_id', $request->product_id)
                    ->where('grade', $grade)
                    ->first();

                if ($priceModel) {
                    $priceModel->qty += $request->qty[$index]; // เพิ่มจำนวนในคลัง
                    $priceModel->save();
                }
            } else {
                // ถ้าไม่มี ให้เพิ่มรายการใหม่
                $buy_d = new Buy_dhomeModel;
                $buy_d->buy_home_id = $buy_home->id; // เชื่อมโยงกับข้อมูลผู้ซื้อ
                $buy_d->product_id = $request->product_id; // สมมติว่ามี product_id มาจากฟอร์ม
                $buy_d->grade = $grade;
                $buy_d->price = $request->price[$index]; // การเปลี่ยน array เป็น string
                $buy_d->qty_buy = $request->qty[$index];

                // คำนวณราคาทั้งหมด
                $buy_d->price_total = $buy_d->price * $buy_d->qty_buy;
                $buy_d->save();

                // บันทึกสินค้าในคลังสินค้า
                $priceModel = PriceModel::where('product_id', $request->product_id)
                    ->where('grade', $grade)
                    ->first();

                if ($priceModel) {
                    $priceModel->qty += $request->qty[$index]; // เพิ่มจำนวนในคลัง
                    $priceModel->save();
                }
            }
        }

        // ส่งกลับไปยังฟอร์มพร้อมข้อความสำเร็จ
        return redirect("/orders-home/detail/{$id}")->with('successs', 'เพิ่มรายการรับซื้อเรียบร้อยแล้ว!');
    }


    public function ordder_home_delete($id)
    {
        $Order = Buy_dhomeModel::getSingle($id);
        if ($Order) {
            $Order->is_delete = 1;
            $Order->save();
        }
        return redirect()->back();
    }

    public function showReceipt($id)
    {
        $data['getdetail'] = BuyhomeModel::getdetail($id);
        // $data['getSingle'] = Buy_dhomeModel::getSingle($id);

        return view('admin.Ordershome.receipt', $data);
    }
}
