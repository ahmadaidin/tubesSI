<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $connection = "mysql";
    protected $table = "setor";
    public $timestamps = false;
}
