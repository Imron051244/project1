<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBuyModel extends Model
{
    use HasFactory;

    protected $table = 'user_buy';

    static public function getSingle($id)
    {
        return self::where('user_buy.is_delete', '=', 0)
            ->find($id);
    }


    static public function getRecord()
    {
        return self::where('user_buy.is_delete', '=', 0)  
            ->select('user_buy.*')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    static public function getdetail($id)
    {
        return self::where('user_buy.is_delete', '=', 0)
            ->join('users', 'users.id', '=', 'user_buy.user_id') // เชื่อมตาราง users
            ->join('districts', 'districts.id', '=', 'user_buy.subdistrict_id')
            ->join('amphures', 'amphures.id', '=', 'districts.amphure_id')
            ->join('provinces', 'provinces.id', '=', 'amphures.province_id')
            ->select(
                'user_buy.*',
                'users.*',
                'districts.*',
                'user_buy.id as users_buy_id',
                'amphures.name_th as districts',
                'provinces.name_th as provinces',
            )
            ->find($id);
    }

    public function getItem()
    {
        return $this ->hasMany(OderBuyModel::class, 'user_buy_id');
    }

    

   
}
