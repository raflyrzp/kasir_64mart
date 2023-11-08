<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreIdentitasRequest;
use App\Http\Requests\UpdateIdentitasRequest;

class IdentitasController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $identitas = Identitas::findOrFail(1);

        return view('identitas.index', [
            'title' => 'Identity',
            'identitas' => $identitas,
            'role' => $role
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'nama_app' => 'required',
            'alamat' => 'required',
            'logo' => 'image|mimes:jpeg,jpg,png|max:2048',
            'background_login' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $role = auth()->user()->role;
        $identitas = Identitas::findOrFail(1);

        if ($request->hasFile('logo')) {
            $this->validate($request, [
                'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            ]);

            $logo = $request->file('logo');
            $logo->storeAs('public/img/logo/', $logo->hashName());

            if ($identitas->logo !== 'default.png') {
                Storage::delete('public/img/logo/' . $identitas->logo);
            }

            $identitas->update([
                'logo' => $logo->hashName(),
            ]);
        }

        if ($request->hasFile('background_login')) {
            $this->validate($request, [
                'background_login' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            ]);

            $backgroundLogin = $request->file('background_login');
            $backgroundLogin->storeAs('public/img/background_login/', $backgroundLogin->hashName());

            if ($identitas->background_login !== 'default.png') {
                Storage::delete('public/img/background_login/' . $identitas->background_login);
            }

            $identitas->update([
                'background_login' => $backgroundLogin->hashName(),
            ]);
        }

        $identitas->update([
            'nama_app' => $request->nama_app,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route($role . '.identitas.index')->with(['success' => 'Successfully updated Identity!']);
    }
}
