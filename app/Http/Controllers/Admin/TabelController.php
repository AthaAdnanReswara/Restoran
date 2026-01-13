<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TabelController extends Controller
{
    // INDEX
    public function index()
    {
        $tables = Table::orderBy('table_number')->get();
        return view('admin.table.index', compact('tables'));
    }

    // CREATE
    public function create()
    {
        return view('admin.table.tambah');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|integer|unique:tables,table_number',
        ]);

        Table::create([
            'table_number' => $request->table_number,
            'status' => 'available',
        ]);

        return redirect()
            ->route('admin.table.index')
            ->with('success', 'Meja berhasil ditambahkan');
    }

    // EDIT
    public function edit(Table $table)
    {
        return view('admin.table.edit', compact('table'));
    }

    // UPDATE
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_number' => 'required|integer|unique:tables,table_number,' . $table->id,
            'status' => 'required|in:available,occupied',
        ]);

        $table->update($request->all());

        return redirect()
            ->route('admin.table.index')
            ->with('success', 'Meja berhasil diperbarui');
    }

    // DELETE
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()
            ->route('admin.table.index')
            ->with('success', 'Meja berhasil dihapus');
    }
}
