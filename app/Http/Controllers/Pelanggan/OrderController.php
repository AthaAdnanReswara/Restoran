<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('index', [
            'tables' => Table::where('status', 'available')->get(),
            'customerName' => session('customer_name'),
            'tableId' => session('table_id'),
        ]);
    }

    public function setCustomer(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_id' => 'required|exists:tables,id',
        ]);

        // Update status meja menjadi occupied
        Table::findOrFail($request->table_id)->update([
            'status' => 'occupied'
        ]);

        session([
            'customer_name' => $request->customer_name,
            'table_id' => $request->table_id,
        ]);

        return redirect()->back();
    }
}
