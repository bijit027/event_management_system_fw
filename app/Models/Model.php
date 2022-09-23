<?php

namespace EventManagementSystem\App\Models;

use EventManagementSystem\Framework\Database\Orm\Model as BaseModel;

class Model extends BaseModel
{
    protected $guarded = ['id', 'ID'];
}