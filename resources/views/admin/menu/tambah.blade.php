@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">➕ Tambah Menu</h5>
        </div>

        <div class="card-body">

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf

                {{-- Nama Menu --}}
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Contoh: Nasi Goreng"
                           value="{{ old('name') }}"
                           required>
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           placeholder="Contoh: 15000"
                           value="{{ old('price') }}"
                           min="0"
                           required>
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="food"  {{ old('category') == 'food' ? 'selected' : '' }}>Makanan</option>
                        <option value="drink" {{ old('category') == 'drink' ? 'selected' : '' }}>Minuman</option>
                        <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success">
                        Simpan Menu
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
