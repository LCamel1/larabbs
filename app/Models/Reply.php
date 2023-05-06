<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
     use HasFactory;

    protected $fillable = ['content'];

    /**
     *  一条回复属于一个话题的回复
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 一条回复只属于一个用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
