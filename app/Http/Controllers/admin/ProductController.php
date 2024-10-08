<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use Illuminate\Support\Str;
use App\Models\PriceModel;

class ProductController extends Controller
{

    public function listpdt()
    {
        $data['getRecord'] = ProductModel::getRecord();
        return view('admin.Product.listpdt', $data);
    }


    public function pdtcreate()
    {
        $getCategory = CategoryModel::getRecordAtive();
        return view('admin.Product.pdtcreate', compact('getCategory'));
    }

    public function productSave(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|string',
            'image' => 'required'
        ], [
            'category_id' => 'กรุณาเลือกประเภทสินค้า',
            'title.required' => 'กรุณากรอกชื่อสินค้า',
            'title.string' => 'ชื่อสินค้าต้องเป็นข้อความ',
            'image.required' => 'กรุณาเลือกรูปภาพ'
        ]);

        $product = new ProductModel;
        $product->category_id = trim($request->category_id);
        $product->title = trim($request->title);
        $product->save();

        if (!empty($request->file('image'))) {
            foreach ($request->file('image') as $value) {
                if ($value->isValid()) {
                    $ext = $value->getClientOriginalExtension();
                    $randomStr = $product->id . Str::random(20);
                    $filename = strtolower($randomStr) . '.' . $ext;
                    $value->move('upload/product/', $filename);
                    $imageupload = new ProductImageModel;
                    $imageupload->image_name = $filename;
                    $imageupload->image_extension = $ext;
                    $imageupload->product_id = $product->id;
                    $imageupload->save();
                }
            }
        }
        
        

        return redirect('product/list')->with('success', 'บันทึกสินค้าสำเสร็จ');
    }

    public function edit($id)
    {
        $data['getPrice'] = PriceModel::getRecordActive($id);
        $data['getCategory'] = CategoryModel::getRecordAtive();
        $data['getRecord'] = ProductModel::getSingle($id);
        return view('admin.Product.pdtedit', $data);
    }

    public function update($id, Request $request)
    {
        $product = ProductModel::getSingle($id);
        $product->category_id = trim($request->category_id);
        $product->title = trim($request->title);
        $product->save();

        if (!empty($request->file('image'))) {
            foreach ($request->file('image') as $value) {
                if ($value->isValid()) {
                    $ext = $value->getClientOriginalExtension();
                    $randomStr = $product->id . Str::random(20);
                    $filename = strtolower($randomStr) . '.' . $ext;
                    $value->move('upload/product/', $filename);
                    $imageupload = new ProductImageModel;
                    $imageupload->image_name = $filename;
                    $imageupload->image_extension = $ext;
                    $imageupload->product_id = $product->id;
                    $imageupload->save();
                }
            }
        }

        return redirect('product/list')->with('success', 'อัพเดดสินค้าสำเสร็จ');
    }

    public function delete($id)
    {
        $product = ProductModel::getSingle($id);
        if ($product) {
            $product->is_delete = 1;
            $product->save();
        }
        return redirect()->back()->with('success', 'ลบสินค้าสำเสร็จ');
    }

    public function delete_image($id)
    {
        $image = ProductImageModel::getSingle($id);
        if (!empty('upload/product/' . $image->image_name));
        $image->delete();

        return redirect()->back()->with('');
    }

    public function image_sortable(Request $request)
    {
        if (!empty($request->photo_id)) {
            $i = 1;
            foreach ($request->photo_id as $photo_id) {
                $image = ProductImageModel::getSingle($photo_id);
                $image->order_by = $i;
                $image->save();

                $i++;
            }
        }

        $json['Success'] = true;
        echo json_encode($json);
    }

    public function ByGrade(Request $request)
    {
        $priceIds = $request->price;
        $price = PriceModel::select('price_buy', 'price_sell')->find($priceIds);

        // ตรวจสอบว่า $price ไม่เป็น null ก่อนเข้าถึง price_buy
        if ($price) {
            return response()->json([
                'price_buy' => $price->price_buy,
                'price_sell' => $price->price_sell
            ]);
        } else {
        }
    }

    public function updateStatusProduct($id)
    {
        // ดึงข้อมูลคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel
        $Product = ProductModel::find($id);

        // ตรวจสอบว่าพบคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel หรือไม่
        if ($Product) {
            // เปลี่ยนสถานะ: ถ้าเป็น 0 จะเปลี่ยนเป็น 1, ถ้าเป็น 1 จะเปลี่ยนเป็น 0
            $Product->status = ($Product->status == 0) ? 1 : 0;

            // บันทึกการเปลี่ยนแปลง
            $Product->save();

            // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
            return redirect()->back();
        } else {
        }
    }
}
