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
        $current_cabang = array();
        foreach ($setor as $index => $setor_item) {
            $key=$setor_item->id_cabang;
            $cab=Cabang::find($key);
            $value=$cab->nama;
            $current_cabang[$key] = $value;
        }

    	return view('listSetor', compact('setor', 'cabang', 'nasabah', 'item', 'current_cabang'));
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

    function editSetor(Request $request)
    {   
        $setor = Setor::find($request->input('id'));
        $setor->id_cabang = $request->input('id_cabang');
        $setor->nama_nasabah = $request->input('nama_nasabah');
        $setor->nama_item = $request->input('nama_item');
        $setor->berat = $request->input('berat');
        $setor->harga = $request->input('harga');
        $setor->tanggal = $request->input('tanggal');
        $setor->save();
        return redirect('/setor');
    }

    function deleteSetor(Request $request)
    {
        $setor=Setor::find($request->input('id'));
        $setor->delete();
        return redirect('/setor');
    }
}