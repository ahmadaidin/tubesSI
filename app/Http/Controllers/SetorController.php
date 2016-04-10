<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Setor;

use App\Cabang;

use App\Nasabah;

use App\Item;

class SetorController extends Controller
{
    function listSetor()
    {   
    	$setor = Setor::get();
    	$cabang = Cabang::get();
    	$nasabah = Nasabah::get();
    	$item = Item::get();
    	return view('listSetor', compact('setor', 'cabang', 'nasabah', 'item'));
    }

    function addSetor(Request $request)
    {   
    	$setor = new Setor;
        $setor->id_cabang = $request->input('id_cabang');
        $setor->nama_nasabah = $request->input('nama_nasabah');
        $setor->nama_item = $request->input('nama_item');
        $setor->berat = $request->input('berat');
        $setor->harga = $request->input('harga');
        $setor->tanggal = $request->input('tanggal');
        $setor->save();
        return redirect('/setor');
    }
}