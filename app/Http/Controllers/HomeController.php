<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // TODO 3
    public function index(Request $request)
    {
        $query = Buku::query();

        // Pencarian kata kunci
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        // Filter ketersediaan stok
        if ($request->stok === 'tersedia') {
            $query->where('stok', '>', 0);
        } elseif ($request->stok === 'habis') {
            $query->where('stok', '<=', 0);
        }

        // Pengurutan
        $sort = $request->get('sort');
        if (in_array($sort, ['judul', 'tahun', 'stok'])) {
            $query->orderBy($sort);
        } else {
            $query->latest();
        }

        // Paginasi dengan mempertahankan parameter URL
        $buku = $query->paginate(12)->withQueryString();

        return view('home', compact('buku'));
    }

    // Detail buku publik
    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        return view('show', compact('buku'));
    }
}