<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::select('users.*')
        ->where('is_delete', 0)
        ->join('districts', 'districts.id', '=', 'users.districts_id')
        ->orderBy('districts.id', 'desc')
        ->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => 'string'
    ];

    protected function getTypeAttribute($value): string
    {
        $types = ['ผู้ซื้อ', 'ผู้ขาย', 'Admin'];
        return $types[$value] ?? 'Unknown';
    }

    protected function setTypeAttribute($value): void
    {
        $types = ['ผู้ซื้อ' => 0, 'ผู้ขาย' => 1, 'Admin' => 2];
        $this->attributes['type'] = $types[$value] ?? 0;
    }
}
