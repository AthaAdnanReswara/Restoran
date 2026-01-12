@extends('layouts.app')

@section('title', 'Data Menu')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>🍽️ Daftar Menu</h3>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
            + Tambah Menu
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>

                        {{-- FOTO MENU --}}
                        <td class="text-center">
                            @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                alt="{{ $menu->name }}"
                                style="width: 70px; height: 70px; object-fit: cover;"
                                class="rounded">
                            @else
                            <span class="text-muted fst-italic">Tidak ada</span>
                            @endif
                        </td>

                        <td>{{ $menu->name }}</td>

                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>

                        <td class="text-center">
                            @if ($menu->category == 'food')
                            <span class="badge bg-success">Makanan</span>
                            @elseif ($menu->category == 'drink')
                            <span class="badge bg-primary">Minuman</span>
                            @else
                            <span class="badge bg-warning text-dark">Snack</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Data menu belum tersedia
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection