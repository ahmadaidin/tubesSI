<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cabang;

class CabangController extends Controller
{
    function listCabang()
    {   
        //$cabang = 
        
        //return view('listlowongan', compact('lowongan','status'));
    	
    	$cabang = Cabang::get();
    	return view('listCabang', compact('cabang'));
    }
}
