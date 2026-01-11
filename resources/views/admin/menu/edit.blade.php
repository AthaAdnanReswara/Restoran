@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0">✏️ Edit Menu</h5>
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

            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Menu --}}
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $menu->name) }}"
                           required>
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           value="{{ old('price', $menu->price) }}"
                           min="0"
                           required>
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="food"  {{ old('category', $menu->category) == 'food' ? 'selected' : '' }}>
                            Makanan
                        </option>
                        <option value="drink" {{ old('category', $menu->category) == 'drink' ? 'selected' : '' }}>
                            Minuman
                        </option>
                        <option value="snack" {{ old('category', $menu->category) == 'snack' ? 'selected' : '' }}>
                            Snack
                        </option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success">
                        Update Menu
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
