<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\PriceModel;

class ProductsController extends Controller
{
  public function home()
  {
    $data['getProducts'] = ProductModel::getRecordAtive();
    return view('welcome', $data);
  }

  public function list()
  {
    $data['getProduct'] = ProductModel::getProduct();
    return view('Product.list', $data);
  }

  public function getCategoryName($id, $title = null)
  {
    // ดึงข้อมูลประเภทหมวดหมู่ของสินค้า
    $getCategoryName = CategoryModel::getSingleCategory($id);

    // ดึงรายการสินค้าจากหมวดหมู่
    $getProduct = ProductModel::getProduct($getCategoryName->id ?? '');

    // ดึงรายละเอียดสินค้าตาม ID
    $getProductDetail = ProductModel::getSingle($id);

    // ดึงข้อมูลราคา
    $getProductPrices = ProductModel::getPricePDT($id);
  
    if (!empty($getProductDetail)) {
      // ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่ และเป็น "ผู้ซื้อ" หรือไม่
      
      // ส่งข้อมูลไปยัง View
      $data['getProductDetail'] = $getProductDetail;
      $data['getProduct'] = $getProduct;
      $data['getProductPrices'] = $getProductPrices;

      return view('Product.detail', $data);
    } elseif (!empty($getCategoryName)) {
      // ส่งข้อมูลไปยัง View ของหมวดหมู่
      $data['getCategoryName'] = $getCategoryName;
      $data['getProduct'] = $getProduct;

      return view('Product.list', $data);
    } else {
      abort(404); // ส่งไปยังหน้าข้อผิดพลาด 404 ถ้าไม่พบข้อมูล
    }
  }

  public function getProductPriceByGrade(Request $request)
  {
    $priceId = $request->price;
    $price = PriceModel::select('price_buy', 'price_sell')
                        ->where('grade', $priceId)
                        ->first();

    // ตรวจสอบว่า $price ไม่เป็น null ก่อนเข้าถึง price_buy
    if ($price) {
      return response()->json([
        'price_buy' => $price->price_buy,
        'price_sell' => $price->price_sell
      ]);
    } else {
      return view('welcome');
    }
  }
}
