<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * 获取所有话题分类，并存入缓存
     */
    public function categories()
    {
        if (is_null(cache('categories'))) {
            cache(['categories' => $this->all()], 480);
        }
        return cache('categories');
    }
}
