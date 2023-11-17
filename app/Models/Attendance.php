<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;
    
     protected $guarded = ['id'];
     //「複数代入によって書き換えられたくないカラム」はここには入れないよう注意。
     

    /**
     * この勤怠表を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    
    
}
