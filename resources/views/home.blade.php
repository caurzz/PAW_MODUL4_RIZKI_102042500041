@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Katalog Buku</h3>

    <form method="GET" action="{{ route('home') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="stok" class="form-select">
                <option value="">Semua Stok</option>
                <option value="tersedia" @selected(request('stok') === 'tersedia')>Tersedia</option>
                <option value="habis" @selected(request('stok') === 'habis')>Habis</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="">Urutkan</option>
                <option value="judul" @selected(request('sort') === 'judul')>Judul</option>
                <option value="tahun" @selected(request('sort') === 'tahun')>Tahun</option>
                <option value="stok" @selected(request('sort') === 'stok')>Stok</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <div class="row">
        @forelse ($buku as $b)
            <div class="col-6 col-md-3 mb-4">
                <div class="card h-100">
                    @if ($b->cover)
                        <img src="{{ asset('storage/' . $b->cover) }}" class="card-img-top"
                             alt="{{ $b->judul }}" style="height:250px;object-fit:cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="height:250px;">Tanpa Sampul</div>
                    @endif

                    <div class="card-body">
                        <h6 class="card-title">{{ $b->judul }}</h6>
                        <p class="card-text small text-muted">{{ $b->penulis }} ({{ $b->tahun }})</p>
                        <span class="badge {{ $b->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $b->stok > 0 ? 'Stok: ' . $b->stok : 'Habis' }}
                        </span>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('buku.publik.show', $b->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Buku tidak ditemukan.</p>
        @endforelse
    </div>

    {{ $buku->links() }}
</div>
@endsection