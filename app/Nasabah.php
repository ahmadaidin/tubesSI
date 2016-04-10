<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $connection = "mysql";
    protected $table = "nasabah";
    public $timestamps = false;
}
