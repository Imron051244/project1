<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getProduct($category_id = null)
    {
        $query = self::select('product.*', 'category.title as category_name')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->where('product.is_delete', '=', 0)
            ->where('product.status', '=', 0);

        if (!empty($category_id)) {
            $query->where('product.category_id', '=', $category_id);
        }

        return $query->orderBy('product.id', 'desc')->paginate(12);
    }




    //ดึงชื่อสินค้าไปที่หน้า User
    static public function getSingleProductName($title)
    {
        return self::where('status', 0)  // ตรวจสอบว่า status เท่ากับ 0
            ->where('is_delete', 0)  // ตรวจสอบว่า is_delete เท่ากับ 0
            ->where('title', $title)  // ตรวจสอบว่า id ตรงกับ $id
            ->first();  // คืนแถวแรกที่ตรงตามเงื่อนไข
    }

    static public function getRecord()
    {
        return self::where('product.is_delete', '=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
            ->join('category', 'category.id', '=', 'product.category_id')
            ->select('product.*', 'category.title as category_name')
            ->orderBy('product.id', 'desc')
            ->get();
    }

    static public function getRecordAtive()
    {
        return self::where('is_delete', '=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
            ->where('product.status', '=', 0)
            ->select('product.*')
            ->orderBy('product.title', 'asc')
            ->get();
    }

    public function getImage()
    {
        return $this->hasMany(ProductImageModel::class, "product_id")->orderBy('order_by', 'asc');
    }

    static public function getImageSingle($product_id)
    {
        return ProductImageModel::where('product_id', '=', $product_id)->orderBy('order_by', 'asc')->first();
    }
    public function getPrice()
    {
        return $this->hasMany(PriceModel::class, "product_id");
    }

    public static function getPricePDT($product_id)
    {
        return PriceModel::where('product_id', $product_id)->get();
    }

    public static function getPrices($product_id)
    {
        return PriceModel::where('product_id', $product_id)->get();
    }

}