<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->get();
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Form tambah menu
     */
    public function create()
    {
        return view('admin.menu.tambah');
    }

    /**
     * Simpan data menu + upload gambar
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|in:food,drink,snack',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'category']);

        // upload gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * Form edit menu
     */
    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }
    
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|in:food,drink,snack',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'category']);

        // jika upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }

            // simpan gambar baru
            $data['image'] = $request->file('image')
                ->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil diupdate');
    }

    /**
     * Hapus menu + gambar
     */
    public function destroy(Menu $menu)
    {
        // hapus file gambar
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }
}
