<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderSellModel extends Model
{
    use HasFactory;

    protected $table = 'sell_d';

    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }




}
