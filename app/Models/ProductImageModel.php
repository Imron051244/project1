<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    use HasFactory;

    protected $table = 'product_image';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    // ฟิลด์ที่สามารถมอบค่าได้
    protected $fillable = [
        'product_id',
        'image_name',
        'image_extension'
    ];

    // // ฟังก์ชันเชื่อมโยงกับโมเดล ProductModel
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    
}
