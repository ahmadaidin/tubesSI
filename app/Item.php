<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = "mysql";
    protected $table = "item";
}