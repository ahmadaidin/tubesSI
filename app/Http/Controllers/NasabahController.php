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
        $current_cabang = array();
        foreach ($nasabah as $index => $nasabah_item) {
            $key=$nasabah_item->id_cabang;
            $cab=Cabang::find($key);
            $value=$cab->nama;
            $current_cabang[$key] = $value;
        }
    	return view('listNasabah', compact('nasabah', 'cabang','current_cabang'));
    }

    function addNasabah(Request $request)
    {   
    	$nasabah = new Nasabah;
        $nasabah->id_cabang = $request->input('id_cabang');
        $nasabah->nama = $request->input('nama');
        $nasabah->save();
        return redirect('/nasabah');
    }

    function editNasabah(Request $request)
    {
        $nasabah = Nasabah::find($request->input('nama_lama'))->first();
        $nasabah->nama = $request->input('nama_baru');
        $nasabah->save();
        return redirect('/nasabah');
    }
    
    function deleteNasabah(Request $request)
    {
        $nasabah=Nasabah::find($request->input('nama'));
        $nasabah->delete();
        return redirect('/nasabah');
    }  

}
