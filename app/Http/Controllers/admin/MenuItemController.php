<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id'      => 'required|exists:menus,id',
            'parent_id'    => 'nullable|exists:menu_items,id',
            'title'        => 'required|string|max:100',
            'url'          => 'nullable|string|max:500',
            'route_name'   => 'nullable|string|max:100',
            'order'        => 'nullable|integer',
            'open_new_tab' => 'nullable|boolean',
        ]);
        $data['open_new_tab'] = $request->boolean('open_new_tab');
        MenuItem::create($data);
        return back()->with('success', 'Menu item added.');
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:100',
            'url'          => 'nullable|string|max:500',
            'route_name'   => 'nullable|string|max:100',
            'order'        => 'nullable|integer',
            'open_new_tab' => 'nullable|boolean',
        ]);
        $data['open_new_tab'] = $request->boolean('open_new_tab');
        $menuItem->update($data);
        return back()->with('success', 'Menu item updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back()->with('success', 'Item removed.');
    }
}