<?php

namespace EventManagementSystem\App\Models;

use EventManagementSystem\App\Models\Model;

class Bike extends Model
{
    protected $table = 'bikes';

    protected $fillable = [
        'store_id',
        'image',
        'brand',
        'model',
        'price',
        'description'
    ];
}
