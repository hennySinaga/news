<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentsModel extends Model
{
    //
    use SoftDeletes;

    protected $table = 'comments';
    protected $fillable = ['news_id', 'content'];

    public function news()
    {
        return $this->hasOne('App\Models\NewsModel');
    }
}
