<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyhomeModel extends Model
{
    use HasFactory;

    protected $table = 'buy_home';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::where('buy_home.is_delete', '=', 0)
            ->select('buy_home.*')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    static public function getdetail($id)
    {
        return self::where('buy_home.is_delete', '=', 0)
            ->select('buy_home.*', 'buy_home.id as home_id')
            ->find($id);
    }

    public function getItem()
    {
        return $this->hasMany(Buy_dhomeModel::class, 'buy_home_id')->orderBy('id', 'desc')->where('buy_home_d.is_delete', '=', 0);
    }
}
