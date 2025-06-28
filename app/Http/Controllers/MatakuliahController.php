<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::orderBy('kode')->paginate(10);
        return view('admin.matakuliah.index', compact('matakuliah'));
    }

    public function create()
    {
        return view('admin.matakuliah.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:10|unique:matakuliah,kode',
            'nama' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
            'jurusan' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Matakuliah::create($request->all());

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan');
    }

    public function edit($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        return view('admin.matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, $id)
    {
        $matakuliah = Matakuliah::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:10|unique:matakuliah,kode,' . $id,
            'nama' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
            'jurusan' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $matakuliah->update($request->all());

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);

        // Check if matakuliah is used in jadwal
        if ($matakuliah->jadwal()->count() > 0) {
            return redirect()->route('admin.matakuliah.index')
                ->with('error', 'Mata kuliah tidak dapat dihapus karena masih digunakan dalam jadwal');
        }

        $matakuliah->delete();

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus');
    }
}
