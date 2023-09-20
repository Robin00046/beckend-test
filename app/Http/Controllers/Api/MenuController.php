<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $test = Menu::all();
        // dd($test);
        return response()->json($test, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
        }
        $data = Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $image_path,
        ]);

        if ($data) {
            return response()->json(['message' => 'Menu created successfully'], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'Menu failed to create'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Menu::destroy($menu->id);

        // return response()->json(['message' => 'Menu deleted successfully'], Response::HTTP_OK);
    }
}
