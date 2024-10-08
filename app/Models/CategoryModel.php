<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'category';


    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecordMenu()
    {
        return self::where('category.is_delete', '=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
            ->where('category.status', '=', 0)
            ->select('category.*')
            ->get();
    }

    public static function getSingleCategory($id)
    {
        return self::where('title', '=', $id)
                    ->where('category.is_delete', '=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
                    ->where('category.status', '=', 0)
                    ->first(); // คืนค่าเป็นอ็อบเจกต์หรือ null
    }

    static public function getRecord()
    {
        return self::where('category.is_delete','=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
            ->select('category.*')
            ->get();
    }

    static public function getRecordAtive()
    {
        return self::where('category.is_delete', '=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
            ->where('category.status', '=', 0)
            ->select('category.*')
            ->orderBy('category.title', 'asc')
            ->get();
    }

   
    public function getProduct()
    {
        return $this->hasMany(ProductModel::class, "category_id")
            ->where('product.is_delete', '=', 0)
            ->where('product.status', '=', 0);
    }

}
