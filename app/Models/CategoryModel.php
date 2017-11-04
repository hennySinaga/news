<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
    //
    use SoftDeletes;

    protected $table = 'category';
    protected $fillable = ['name'];

    public function news()
    {
        return $this->hasMany('App\Models\NewsModel');
    }
}
