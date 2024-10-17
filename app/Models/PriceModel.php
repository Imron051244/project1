<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceModel extends Model
{
    use HasFactory;

    protected $table = 'price';

    static public function getSingles($id)
    {
        return self::find($id);
    }

    static public function getSingle($id, $productId)
    {
        return self::where('grade', $id)
            ->where('product_id', $productId)
            ->first();
    }

    static public function getRecord()
    {
        return self::where('product.status', 0)
            ->where('price.is_delete', '=', 0)  // เพิ่มเงื่อนไขก่อนการดึงข้อมูล
            ->join('product', 'product.id', '=', 'price.product_id')
            ->orderBy('id', 'desc')
            ->select('price.*', 'product.title as product_name',)
            ->paginate(10);
    }

    static public function getRecordActive($id)
    {
        return self::where('price.status', '=', 0)
            ->where('price.is_delete', '=', 0)
            ->where('product_id', $id)
            ->orderBy('price.grade', 'asc')
            ->select('price.*')
            ->first();
    }


    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
