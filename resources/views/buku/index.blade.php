@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Buku</h3>

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
            @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="form-control" value="{{ old('penulis') }}" required>
            @error('penulis') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ old('tahun') }}" required>
            @error('tahun') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" min="0" value="{{ old('stok') }}" required>
            @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- TODO 7: input sampul + preview --}}
        <div class="mb-3">
            <label for="cover" class="form-label">Sampul Buku</label>
            <input type="file" name="cover" id="cover" class="form-control" accept="image/*" onchange="previewCover(event)">
            @error('cover') <small class="text-danger">{{ $message }}</small> @enderror
            <img id="preview" src="#" alt="Preview sampul" class="mt-2 d-none" style="max-height:200px;">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
function previewCover(event) {
    const img = document.getElementById('preview');
    const file = event.target.files[0];
    if (file) {
        img.src = URL.createObjectURL(file);
        img.classList.remove('d-none');
    } else {
        img.classList.add('d-none');
    }
}
</script>
@endsection