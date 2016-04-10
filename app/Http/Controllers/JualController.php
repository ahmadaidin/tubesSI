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
    	return view('listJual', compact('jual', 'cabang', 'item'));
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
}
