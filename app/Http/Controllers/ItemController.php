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
}