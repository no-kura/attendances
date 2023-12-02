<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;
    
    protected $table = 'summarys'; // ここで任意の名前を設定
    
    protected $guarded = ['id'];
     //「複数代入によって書き換えられたくないカラム」はここには入れないよう注意。
     
    // protected $fillable = [
    //     'user_id',
    //     'summary_date',
    //     'working_days',
    //     'working_times',
    // ];
    
    /**
     * この勤怠一覧を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
