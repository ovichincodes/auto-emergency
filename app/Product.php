<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // table name
    protected $table = 'products';
    // primary key
    public $primaryKey = 'id';
    // timestamps
    public $timestamps = true;
    // let format be used on dates
    protected $dates = ['created_at', 'updated_at'];

    // one to one relationship with category
    public function category() {
        return $this->belongsTo('App\Category');
    }
}