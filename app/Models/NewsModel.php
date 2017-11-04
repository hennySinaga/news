<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsModel extends Model
{
    //
    use SoftDeletes;

    protected $table = 'news';
    protected $fillable = ['category_id', 'title', 'description'];

    public function category()
    {
        return $this->hasOne('App\Models\CategoryModel');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\CommentsModel', 'news_id');
    }
}
