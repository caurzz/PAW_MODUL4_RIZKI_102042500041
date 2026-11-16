@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Buku</h3>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>No</th>
                {{-- TODO 9: kolom thumbnail sampul --}}
                <th>Sampul</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku as $b)
                <tr>
                    <td>{{ $buku->firstItem() + $loop->index }}</td>

                    {{-- TODO 9: tampilkan thumbnail --}}
                    <td>
                        @if ($b->cover)
                            <img src="{{ asset('storage/' . $b->cover) }}" alt="{{ $b->judul }}"
                                 width="50" height="70" style="object-fit:cover;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td>{{ $b->judul }}</td>
                    <td>{{ $b->penulis }}</td>
                    <td>{{ $b->tahun }}</td>
                    <td>{{ $b->stok }}</td>
                    <td>
                        <a href="{{ route('buku.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('buku.destroy', $b->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $buku->links() }}
</div>
@endsection