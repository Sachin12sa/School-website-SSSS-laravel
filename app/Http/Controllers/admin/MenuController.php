<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('allItems')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.form', ['menu' => new Menu]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'location' => 'required|string|max:50',
        ]);
        Menu::create($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu created.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.form', ['menu' => $menu->load('allItems')]);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'location' => 'required|string|max:50',
        ]);
        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu updated.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu deleted.');
    }
}