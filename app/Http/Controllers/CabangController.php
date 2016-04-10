<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cabang;

class CabangController extends Controller
{
    function listCabang()
    {   
    	$cabang = Cabang::get();
    	return view('listCabang', compact('cabang'));
    }

    function addCabang(Request $request)
    {   
    	$cabang = new Cabang;
        $cabang->nomor_registrasi = $request->input('nomor_registrasi');
        $cabang->nama = $request->input('nama');
        $cabang->kecamatan = $request->input('kecamatan');
        $cabang->kelurahan = $request->input('kelurahan');
        $cabang->rw = $request->input('rw');
        $cabang->rt = $request->input('rt');
        $cabang->save();
        return redirect('/cabang');
    }
}
