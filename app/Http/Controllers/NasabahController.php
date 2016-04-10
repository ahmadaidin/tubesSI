<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Nasabah;

use App\Cabang;

class NasabahController extends Controller
{
    function listNasabah()
    {   
    	$nasabah = Nasabah::get();
    	$cabang = Cabang::get();
    	return view('listNasabah', compact('nasabah', 'cabang'));
    }

    function addNasabah(Request $request)
    {   
    	$nasabah = new Nasabah;
        $nasabah->id_cabang = $request->input('id_cabang');
        $nasabah->nama = $request->input('nama');
        $nasabah->save();
        return redirect('/nasabah');
    }
}
