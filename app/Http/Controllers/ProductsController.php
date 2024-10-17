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

  public function getProductByCategory($categoryId)
  {
    // ดึงข้อมูลประเภทหมวดหมู่ของสินค้า
    $category = CategoryModel::getSingleCategory($categoryId);

    if (!$category) {
      abort(404); // หากไม่พบหมวดหมู่ ส่งไปที่หน้าข้อผิดพลาด 404
    }

    // ดึงรายการสินค้าจากหมวดหมู่
    $products = ProductModel::getProduct($category->id);

    // ส่งข้อมูลไปยัง View สำหรับแสดงรายการสินค้าในหมวดหมู่
    return view('Product.list', ['category' => $category, 'getProduct' => $products]);
  }

  public function getProductDetail($productId)
  {
    // ดึงรายละเอียดสินค้าตาม ID
    $product = ProductModel::getSingle_Product($productId);

    if (!$product) {
      abort(404); // หากไม่พบสินค้า ส่งไปที่หน้าข้อผิดพลาด 404
    }

    // ดึงข้อมูลราคาสินค้า
    $prices = ProductModel::getPricePDT($product->id);

    // ส่งข้อมูลไปยัง View สำหรับแสดงรายละเอียดสินค้า
    return view('Product.detail', 
    ['getProductDetail' => $product, 
           'getProductPrices' => $prices]);
  }

  public function getProductPriceByGrade(Request $request)
  {
    $priceId = $request->price;
    $productId = $request->product_id;

    $price = PriceModel::select('price_buy', 'price_sell')
      ->where('grade', $priceId)
      ->where('product_id', $productId)
      ->first();

    // ตรวจสอบว่า $price ไม่เป็น null ก่อนเข้าถึง price_buy
    if ($price) {
      return response()->json([
        'price_buy' => $price->price_buy,
        'price_sell' => $price->price_sell
      ]);
    } else {
      // ส่งกลับ JSON ถ้าไม่พบราคาที่ต้องการ
      return response()->json([
        'error' => 'ไม่พบราคาสำหรับเกรดที่เลือก'
      ], 404); // ส่งกลับสถานะ 404 ถ้าไม่พบข้อมูล
    }
  }
}
