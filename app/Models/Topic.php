<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id',  'excerpt', 'slug'];

    /**
     * 一个话题只属于一个用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * 一个话题只属于一个分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * show 用上友好URL
     */
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
