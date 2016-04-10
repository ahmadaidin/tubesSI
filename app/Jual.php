<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jual extends Model
{
    protected $connection = "mysql";
    protected $table = "jual";
    public $timestamps = false;
}
