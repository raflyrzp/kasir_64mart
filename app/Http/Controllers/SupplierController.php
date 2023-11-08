<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $data_supplier = Supplier::all();
        $identitas = Identitas::findOrFail(1);

        return view('transaksi.supplier.index', [
            'title' => 'Suppliers',
            'data_supplier' => $data_supplier,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function store(Request $request)
    {
        $role = auth()->user()->role;

        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|numeric|min:11',
        ]);

        Supplier::create($request->all());

        return redirect()->route($role . '.supplier.index')->with('success', 'Successfully created a supplier');
    }

    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|numeric|min:11',
        ]);

        $supplier = Supplier::find($id);
        $supplier->update($request->all());

        return redirect()->route($role . '.supplier.index')->with('success', 'Successfully updated a supplier');
    }

    public function destroy($id)
    {
        $role = auth()->user()->role;
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect()->route($role . '.supplier.index')->with('success', 'Successfully deleted a supplier');
    }
}
