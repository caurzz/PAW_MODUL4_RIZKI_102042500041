<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::latest()->paginate(10);
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    // TODO 4: simpan buku + upload sampul
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun'   => 'required|integer',
            'stok'    => 'required|integer|min:0',
            'cover'   => 'nullable|image|max:2048', // image, maksimal 2048 KB
        ]);

        if ($request->hasFile('cover')) {
            // simpan ke storage/app/public/buku
            $validated['cover'] = $request->file('cover')->store('buku', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    // TODO 5: update buku, hapus sampul lama jika ada sampul baru
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun'   => 'required|integer',
            'stok'    => 'required|integer|min:0',
            'cover'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            // hapus berkas sampul lama jika ada
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }

            // simpan sampul baru
            $validated['cover'] = $request->file('cover')->store('buku', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // TODO 6: hapus berkas sampul sebelum data dihapus dari database
    public function destroy(Buku $buku)
    {
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}