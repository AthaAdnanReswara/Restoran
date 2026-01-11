<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = User::where('role', 'pegawai')->latest()->get();
        return view('admin.pegawai.index', compact('pegawais'));
    }

    /**
     * Form tambah pegawai
     */
    public function create()
    {
        return view('admin.pegawai.tambah');
    }

    /**
     * Simpan pegawai baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pegawai',
        ]);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Form edit pegawai
     */
    public function edit(User $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update pegawai
     */
    public function update(Request $request, User $pegawai)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pegawai->id,
        ]);

        $pegawai->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $pegawai->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    /**
     * Hapus pegawai
     */
    public function destroy(User $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus');
    }
}
