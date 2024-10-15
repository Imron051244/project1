<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderBuy_dModel extends Model
{
    use HasFactory;

    protected $table = 'buy_d_d';

    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    static public function getSingle($id)
    {
        return self::where('buy_d_d.is_delete', '=', 0)
            ->find($id);
    }

}
