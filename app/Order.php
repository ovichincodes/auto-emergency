<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    // mass assignable fields
    protected $fillable = [
        'items', 'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}