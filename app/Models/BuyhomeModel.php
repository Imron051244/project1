<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyhomeModel extends Model
{
    use HasFactory;

    protected $table = 'buy_home';

    static public function getRecord()
    {
        return self::where('buy_home.is_delete', '=', 0)  
            ->select('buy_home.*')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

}
