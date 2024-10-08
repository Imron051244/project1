<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderBuyModel extends Model
{
    use HasFactory;

    protected $table = 'buy_d';

    static public function getSingle_edit($id)
    {
        return self::where('buy_d.is_delete', '=', 0)
            ->where('id', $id)
            ->first();
    }

    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function getPrice()
    {
        return $this->belongsTo(PriceModel::class, "product_id");
    }
}
