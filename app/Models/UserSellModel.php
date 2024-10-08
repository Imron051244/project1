<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSellModel extends Model
{
    use HasFactory;

    protected $table = 'user_sell';

    static public function getSingle($id)
    {
        return self::where('user_sell.is_delete', '=', 0)
            ->find($id);
    }

    static public function getdetail($id)
    {
        return self::where('user_sell.is_delete', '=', 0)
            ->join('users', 'users.id', '=', 'user_sell.user_id') // เชื่อมตาราง users
            ->join('districts', 'districts.id', '=', 'user_sell.subdistrict_id')
            ->join('amphures', 'amphures.id', '=', 'districts.amphure_id')
            ->join('provinces', 'provinces.id', '=', 'amphures.province_id')
            ->select(
                'user_sell.*',
                'users.*',
                'districts.*',
                'user_sell.id as users_sell_id',
                'amphures.name_th as districts',
                'provinces.name_th as provinces',
            )
            ->find($id);
    }


    static public function getRecord()
    {
        return self::where('user_sell.is_delete', '=', 0)  
            ->select('user_sell.*')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function getItem()
    {
        return $this->hasMany(OderSellModel::class, 'user_sell_id');
    }

}
