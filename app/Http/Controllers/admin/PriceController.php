<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\PriceModel;

class PriceController extends Controller
{

    public function list()
    {
        $getRecord = PriceModel::getRecord();
        return view('admin.Price.list', compact('getRecord'));
    }
    public function create()
    {
        $data = [
            'getRecord' => PriceModel::getRecord(), // ดึงข้อมูลทั้งหมดของ PriceModel
            'getProduct' => ProductModel::getRecordAtive(), // ดึงข้อมูลทั้งหมดของ ProductModel ที่ใช้งานอยู่
        ];

        return view('admin.Price.create', $data);
    }

    public function priceSave(Request $request)
    {

        $request->validate([
            'product_id' => 'required',
            'grade' => 'required|string',
            'price_sell' => 'required|numeric',
            'price_buy' => 'required|numeric',
        ], [
            'product_id.required' => 'กรุณาเลือกสินค้า',       // ถ้าไม่เลือกสินค้า
            'grade.required' => 'กรุณาเลือกเกรดสินค้า',         // ถ้าไม่ได้เลือกเกรด
            'price_sell.required' => 'กรุณากรอกราคาขาย',        // ถ้าไม่ได้กรอกราคาขาย
            'price_sell.numeric' => 'ราคาขายต้องเป็นตัวเลขเท่านั้น',  // ถ้าราคาขายไม่เป็นตัวเลข
            'price_buy.required' => 'กรุณากรอกราคารับซื้อ',     // ถ้าไม่ได้กรอกราคารับซื้อ
            'price_buy.numeric' => 'ราคารับซื้อต้องเป็นตัวเลขเท่านั้น',  // ถ้าราคารับซื้อไม่เป็นตัวเลข
        ]);

        //  ตรวจสอบว่า price_sell น้อยกว่า price_buy
        // if ($request->price_buy >= $request->price_sell) {
        //     return back()->withErrors(['price_sell' => 'ราคาขายต้องน้อยกว่าราคารับซื้อ']);
        // }

        // ตรวจสอบว่ามีสินค้าและเกรดเดียวกันในฐานข้อมูลอยู่แล้วหรือไม่
        $existingPrice = PriceModel::where('product_id', trim($request->product_id))
            ->where('grade', trim($request->grade))
            ->exists();

        if ($existingPrice) {
            // ถ้ามีอยู่แล้ว ให้ส่ง error กลับไปหรือแจ้งผู้ใช้
            return redirect()->back()->with('error', 'สินค้าหรือเกรดนี้มีอยู่แล้ว');
        }


        $Price = new PriceModel;
        $Price->product_id = trim($request->product_id);
        $Price->grade = trim($request->grade);
        $Price->price_sell = trim($request->price_sell);
        $Price->price_buy = trim($request->price_buy);
        $Price->qty = trim($request->qty);
        $Price->save();

        return redirect('/price')->with('success', 'บันทึกสำเสร็จ');
    }

    public function edit($id)
    {
        $getRecord = PriceModel::getRecord();
        $getProduct = ProductModel::getRecordAtive();
        $getRecord = PriceModel::getSingles($id);

        return view('admin.Price.edit', compact('getRecord', 'getProduct'));
    }

    public function update($id, Request $request)
    {

        $Price = PriceModel::getSingles($id);
        $Price->grade = trim($request->grade);
        $Price->price_sell = trim($request->price_sell);
        $Price->price_buy = trim($request->price_buy);
        $Price->qty = trim($request->qty);
        $Price->save();



        return redirect('/price')->with('success', 'บันทึกสินค้าสำเสร็จ');
    }

    public function delete($id)
    {
        $Price = PriceModel::getSingles($id);
        if ($Price) {
            $Price->is_delete = 1;
            $Price->save();
        }
        return redirect()->back()->with('success', 'ลบสินค้าสำเสร็จ');
    }
}
