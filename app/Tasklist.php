<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    protected $fillable = ['content'];
    
    /**
    * このタスクを所有するユーザ。（Userモデルとの関係を定義）
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}