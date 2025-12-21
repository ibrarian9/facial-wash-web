<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController
{
    public function criteriaCreate()
    {
        return view('spk.criteria_form');
    }

    public function criteria()
    {
        $criterias = Criteria::all();
        return view('spk.criteria', compact('criterias'));
    }

    // 2. Simpan Data Baru
    public function criteriaStore(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:criterias,code',
            'name' => 'required',
            'weight' => 'required|numeric',
            'type' => 'required|in:benefit,cost',
        ]);

        \App\Models\Criteria::create($request->all());

        return redirect()->route('spk.criteria')->with('success', 'Data kriteria berhasil ditambahkan.');
    }

    // 3. Tampilkan Form Edit
    public function criteriaEdit($id)
    {
        $criteria = \App\Models\Criteria::findOrFail($id);
        return view('spk.criteria_form', compact('criteria'));
    }

    // 4. Update Data
    public function criteriaUpdate(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:criterias,code,' . $id, // Ignore unique for current id
            'name' => 'required',
            'weight' => 'required|numeric',
            'type' => 'required|in:benefit,cost',
        ]);

        $criteria = \App\Models\Criteria::findOrFail($id);
        $criteria->update($request->all());

        return redirect()->route('spk.criteria')->with('success', 'Data kriteria berhasil diperbarui.');
    }

    // 5. Hapus Data
    public function criteriaDestroy($id)
    {
        \App\Models\Criteria::destroy($id);
        return redirect()->route('spk.criteria')->with('success', 'Data kriteria berhasil dihapus.');
    }
}
