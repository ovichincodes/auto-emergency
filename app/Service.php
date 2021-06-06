<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // table name
    protected $table = 'services';
    // primary key
    public $primaryKey = 'id';
    // timestamps
    public $timestamps = true;
    // let format be used on dates
    protected $dates = ['created_at', 'updated_at'];
}