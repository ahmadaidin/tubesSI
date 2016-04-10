<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CabangController extends Controller
{
    function listCabang()
    {   
        //$cabang = 
        
        //return view('listlowongan', compact('lowongan','status'));
    	return view('listCabang');
    }
}
