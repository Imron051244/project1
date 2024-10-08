<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function listcategory()
    {
        $getRecord = CategoryModel::getRecord();
        return view('admin.Category.listcategory', compact('getRecord'));
    }



    public function create()
    {
        return view('admin.Category.catecreate');
    }

    public function categorySave(Request $request)
    {

        $request->validate([
            'title' => 'required|string|unique:category,title', // ตรวจสอบว่าชื่อประเภทสินค้าต้องไม่ว่างและไม่ซ้ำ
        ], [
            'title.required' => 'กรุณากรอกประเภทสินค้า', // ข้อความ error เมื่อไม่ได้กรอกชื่อประเภท
            'title.string' => 'ประเภทสินค้าต้องเป็นข้อความ', // ข้อความ error เมื่อไม่ใช่ข้อความ
            'title.unique' => 'ประเภทสินค้านี้มีอยู่แล้ว', // ข้อความ error เมื่อชื่อประเภทซ้ำ
        ]);

        $category = new CategoryModel;
        $category->title = trim($request->title);
        $category->save();

        return redirect('/Category/list')->with('success', 'บันทึกประเภทสินค้าสำเสร็จ');
    }

    public function edit($id)
    {
        $getRecord = CategoryModel::getSingle($id);
        return view('admin.Category.edit', compact('getRecord'));
    }

    public function update($id, Request $request)
    {

        $request->validate([
            'title' => 'required|string',
        ], [
            'title.required' => 'กรุณากรอกประเภทสินค้า',
            'title.string' => 'ประเภทสินค้าต้องเป็นข้อความ',
        ]);

        $category = CategoryModel::getSingle($id);
        $category->title = trim($request->title);
        $category->save();

        return redirect('/Category/list')->with('success', 'อัพเดดประเภทสินค้าสำเสร็จ');
    }

    public function delete($id)
    {
        $category = CategoryModel::getSingle($id);
        $category->is_delete = 1;
        $category->save();

        return redirect()->back()->with('success', 'ลบประเภทสินค้าสำเสร็จ');
    }

    public function updateStatus($id)
    {

        // ดึงข้อมูลคำสั่งซื้อจากฐานข้อมูล
        $category = CategoryModel::find($id);

        // ตรวจสอบว่าพบคำสั่งซื้อหรือไม่
        if ($category) {
            // เปลี่ยนสถานะ: ถ้าเป็น 0 จะเปลี่ยนเป็น 1, ถ้าเป็น 1 จะเปลี่ยนเป็น 0
            $category->status = ($category->status == 0) ? 1 : 0;

            // บันทึกการเปลี่ยนแปลง
            $category->save();

            // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
            return redirect()->back()->with('success', 'สถานะถูกอัปเดตเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบคำสั่งซื้อ');
        }
    }
}
