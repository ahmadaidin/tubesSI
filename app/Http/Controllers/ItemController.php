<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Item;

class ItemController extends Controller
{
    function listItem()
    {   
    	$item = Item::get();
    	return view('listItem', compact('item'));
    }

    function addItem(Request $request)
    {   
    	$item = new Item;
        $item->nama = $request->input('nama');
        $item->save();
        return redirect('/item');
    }

    function editItem(Request $request)
    {
        $item = Item::find($request->input('nama_lama'));
        $item->nama = $request->input('nama_baru');
        $item->save();
        return redirect('/item');
    }
    
    function deleteItem(Request $request)
    {
        $item=Item::find($request->input('nama'));
        $item->delete();
        return redirect('/item');
    }  


}