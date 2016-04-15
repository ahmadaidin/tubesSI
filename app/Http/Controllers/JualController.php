<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Jual;

use App\Cabang;

use App\Item;

class JualController extends Controller
{
    function listJual()
    {   
    	$jual = Jual::get();
    	$cabang = Cabang::get();
    	$item = Item::get();
        $current_cabang = array();
        foreach ($jual as $index => $jual_item) {
            $key=$jual_item->id_cabang;
            $cab=Cabang::find($key);
            $value=$cab->nama;
            $current_cabang[$key] = $value;
        }
    	return view('listJual', compact('jual', 'cabang', 'item','current_cabang'));
    }

    function addJual(Request $request)
    {   
    	$jual = new Jual;
        $jual->id_cabang = $request->input('id_cabang');
        $jual->pengepul = $request->input('pengepul');
        $jual->nama_item = $request->input('nama_item');
        $jual->berat = $request->input('berat');
        $jual->harga = $request->input('harga');
        $jual->tanggal = $request->input('tanggal');
        $jual->save();
        return redirect('/jual');
    }

    function editJual(Request $request)
    {   
        $jual = Jual::find($request->input('id'));
        $jual->id_cabang = $request->input('id_cabang');
        $jual->pengepul = $request->input('pengepul');
        $jual->nama_item = $request->input('nama_item');
        $jual->berat = $request->input('berat');
        $jual->harga = $request->input('harga');
        $jual->tanggal = $request->input('tanggal');
        $jual->save();
        return redirect('/jual');
    }

    function deleteJual(Request $request)
    {
        $jual=Jual::find($request->input('id'));
        $jual->delete();
        return redirect('/jual');
    }
}
