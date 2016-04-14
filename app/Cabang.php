<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model 
{
    protected $connection = "mysql";
    protected $table = "cabang";
    public $timestamps = false;
    protected $primaryKey = "nomor_registrasi";
    public $incrementing = false;
}