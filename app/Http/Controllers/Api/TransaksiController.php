<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaksi::join('menus', 'transaksis.menu_id', '=', 'menus.id')
            ->selectRaw('count(menus.id) as jumlah, menus.name, menus.price, menus.image')
            ->groupBy('menus.id')
            ->get();
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'menu_id' => 'required',
        ]);
        $data = Transaksi::create([
            'menu_id' => $request->menu_id
        ]);
         return response($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Transaksi::truncate();
        return response()->json(['message' => 'Transaksi deleted successfully'], 200);

    }
}
