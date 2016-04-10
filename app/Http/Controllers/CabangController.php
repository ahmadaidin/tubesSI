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
        $cabang->id = $request->input('nomor_registrasi');
        $cabang->nama = $request->input('nama');
        $cabang->kecamatan = $request->input('kecamatan');
        $cabang->kelurahan = $request->input('kelurahan');
        $cabang->rw = $request->input('rw');
        $cabang->rt = $request->input('rt');
        $cabang->save();
        /*
        $cabang->id = 'id';
        $cabang->nama ='nama';
        $cabang->kecamatan = 'kecamatan';
        $cabang->kelurahan = 'kelurahan';
        $cabang->rw = 'rw';
        $cabang->rt = 'rw';
        $cabang->save();
		DB::table('users')->insert(
    array('email' => 'john@example.com', 'votes' => 0)
);
        */

        return redirect('/');
    }
}
