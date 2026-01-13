@extends('layouts.app')

@section('title', 'Data Menu')

@section('content')
    <section class="mt-6 px-4 pb-20 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    🍽️ Daftar Menu
                </h2>
                <div class="h-1 w-24 bg-yellow-500 rounded mt-2"></div>
            </div>

            <a href="{{ route('admin.menu.create') }}"
                class="inline-flex items-center justify-center rounded-xl
                  bg-yellow-500 hover:bg-yellow-600
                  px-5 py-2 text-white font-semibold transition">
                + Tambah Menu
            </a>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <!-- Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Foto</th>
                            <th class="px-4 py-3">Nama Menu</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3 text-center">Kategori</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($menus as $menu)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-center font-medium">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- Foto -->
                                <td class="px-4 py-3 text-center">
                                    @if ($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                            class="w-16 h-16 object-cover rounded-xl mx-auto">
                                    @else
                                        <span class="text-gray-400 italic text-xs">
                                            Tidak ada
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 font-semibold text-gray-800">
                                    {{ $menu->name }}
                                </td>

                                <td class="px-4 py-3">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </td>

                                <!-- Kategori -->
                                <td class="px-4 py-3 text-center">
                                    @if ($menu->category === 'food')
                                        <span
                                            class="inline-flex items-center rounded-full
                                                 bg-green-100 text-green-700
                                                 px-3 py-1 text-xs font-semibold">
                                            Makanan
                                        </span>
                                    @elseif ($menu->category === 'drink')
                                        <span
                                            class="inline-flex items-center rounded-full
                                                 bg-blue-100 text-blue-700
                                                 px-3 py-1 text-xs font-semibold">
                                            Minuman
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full
                                                 bg-yellow-100 text-yellow-700
                                                 px-3 py-1 text-xs font-semibold">
                                            Snack
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.menu.edit', $menu->id) }}"
                                            class="rounded-lg bg-yellow-400 hover:bg-yellow-500
                                              px-3 py-1 text-white text-xs font-semibold transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="rounded-lg bg-red-500 hover:bg-red-600
                                                   px-3 py-1 text-white text-xs font-semibold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-400 italic">
                                    Data menu belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection
