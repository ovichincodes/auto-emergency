<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // table name
    protected $table = 'categories';
    // primary key
    public $primaryKey = 'id';
    // timestamps
    public $timestamps = true;
    // let format be used on dates
    protected $dates = ['created_at', 'updated_at'];

    // one to many relationship with products
    public function products() {
        return $this->hasMany('App\Product');
    }
}