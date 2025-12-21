<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use Illuminate\Http\Request;

class AlternativeController
{

    public function alternatives()
    {
        $alternatives = Alternative::all();
        return view('spk.alternatives', compact('alternatives'));
    }

    public function createAlternative()
    {
        return view('spk.alternative_form');
    }

    public function storeAlternative(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:alternatives,code',
            'name' => 'required'
        ], [
            'code.unique' => 'Kode alternatif sudah digunakan!'
        ]);

        Alternative::create($request->only('code', 'name'));

        return redirect()->route('spk.alternatives')->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function editAlternative($id)
    {
        $alternative = Alternative::findOrFail($id);
        return view('spk.alternative_form', compact('alternative'));
    }

    public function updateAlternative(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:alternatives,code,' . $id,
            'name' => 'required'
        ]);

        $alternative = Alternative::findOrFail($id);
        $alternative->update($request->only('code', 'name'));

        return redirect()->route('spk.alternatives')->with('success', 'Alternatif berhasil diperbarui.');
    }

    public function destroyAlternative($id)
    {
        $alternative = Alternative::findOrFail($id);
        $alternative->delete();

        return redirect()->route('spk.alternatives')->with('success', 'Alternatif berhasil dihapus.');
    }
}
