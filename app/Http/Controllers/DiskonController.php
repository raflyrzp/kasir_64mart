<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Identitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DiskonController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $data_diskon = Diskon::all();
        $identitas = Identitas::findOrFail(1);

        return view('transaksi.diskon.index', [
            'title' => 'Discounts',
            'data_diskon' => $data_diskon,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_diskon' => 'required|string',
            'besar_diskon' => 'required|numeric',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
        ]);

        Diskon::create($request->all());

        return redirect()->route($role . '.diskon.index')->with('success', 'Successfully added a Discount.');
    }

    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_diskon' => 'required|string',
            'besar_diskon' => 'required|numeric',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
        ]);

        $diskon = Diskon::find($id);
        $diskon->update($request->all());

        return redirect()->route($role . '.diskon.index')->with('success', 'Succesfully updated a Discount.');
    }

    // public function destroy($id)
    // {
    //     $role = auth()->user()->role;
    //     $diskon = Diskon::find($id);
    //     $diskon->delete();

    //     return redirect()->route($role . '.diskon.index')->with('success', 'Successfully deleted a Discount.');
    // }

    public function destroy($id)
    {
        $role = auth()->user()->role;
        $diskon = Diskon::find($id);

        $tanggalBerakhir = Carbon::parse($diskon->tanggal_berakhir);
        if ($tanggalBerakhir->isPast()) {
            $diskon->delete();
            return redirect()->route($role . '.diskon.index')->with('success', 'Successfully deleted an expired Discount.');
        }

        return redirect()->route($role . '.diskon.index')->with('error', 'Cannot delete an active Discount.');
    }
}
