<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderSellModel extends Model
{
    use HasFactory;

    protected $table = 'sell_d';


    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }




}
