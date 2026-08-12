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
            <div class="h-1 w-53 bg-yellow-500 rounded mt-2"></div>
        </div>

        <a href="{{ route('admin.menu.create') }}"
            class="rounded-xl bg-yellow-500 hover:bg-yellow-600
                   px-5 py-2 text-white font-semibold transition">
            + Tambah Menu
        </a>
    </div>

    <!-- Alert -->
    @if (session('success'))
    <div class="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
    @endif


    {{-- ================= HP (CARD) ================= --}}
    <div class="grid grid-cols-1 gap-4 sm:hidden">

        @foreach ($menus as $menu)

        <div class="bg-white rounded-2xl shadow border p-4 flex gap-4">

            <!-- Foto -->
            <div class="w-20 h-20 flex-shrink-0">

                @if ($menu->image)

                <img src="{{ asset('storage/'.$menu->image) }}"
                    class="w-full h-full object-cover rounded-xl">

                @else

                <div class="w-full h-full bg-gray-100 rounded-xl
                            flex items-center justify-center text-xs text-gray-400">
                    No Image
                </div>

                @endif

            </div>


            <!-- Informasi -->
            <div class="flex-1 min-w-0">

                <h3 class="font-bold text-lg">
                    {{ $menu->name }}
                </h3>

                <p class="text-sm text-gray-600">
                    Rp {{ number_format($menu->price,0,',','.') }}
                </p>


                <!-- Kategori -->
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold
                    {{ $menu->category == 'food'
                        ? 'bg-green-100 text-green-700'
                        : ($menu->category == 'drink'
                            ? 'bg-blue-100 text-blue-700'
                            : 'bg-yellow-100 text-yellow-700') }}">

                    {{ ucfirst($menu->category) }}

                </span>


                <!-- STOK -->
                <div class="mt-2">

                    @if ($menu->stok > 10)

                        <span class="inline-flex items-center gap-1
                            px-3 py-1 rounded-full
                            bg-green-100 text-green-700
                            text-xs font-semibold">

                            ✓ Stok: {{ $menu->stok }}

                        </span>

                    @elseif ($menu->stok > 0)

                        <span class="inline-flex items-center gap-1
                            px-3 py-1 rounded-full
                            bg-yellow-100 text-yellow-700
                            text-xs font-semibold">

                            ⚠ Stok: {{ $menu->stok }}

                        </span>

                    @else

                        <span class="inline-flex items-center gap-1
                            px-3 py-1 rounded-full
                            bg-red-100 text-red-700
                            text-xs font-semibold">

                            ✕ Habis

                        </span>

                    @endif

                </div>


                <!-- Tombol -->
                <div class="flex gap-2 mt-3">

                    <a href="{{ route('admin.menu.edit',$menu->id) }}"
                        class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500
                        text-white rounded text-xs transition">

                        Edit

                    </a>


                    <form action="{{ route('admin.menu.destroy',$menu->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus menu ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="px-3 py-1 bg-red-500 hover:bg-red-600
                            text-white rounded text-xs transition">

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>


    {{-- ================= LAPTOP (TABLE) ================= --}}
    <div class="hidden sm:block bg-white rounded-2xl shadow border overflow-hidden mt-4">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-100 text-xs uppercase">

                    <tr>

                        <th class="px-4 py-3 text-center">
                            No
                        </th>

                        <th class="px-4 py-3 text-center">
                            Foto
                        </th>

                        <th class="px-4 py-3">
                            Nama
                        </th>

                        <th class="px-4 py-3">
                            Harga
                        </th>

                        <th class="px-4 py-3 text-center">
                            Stok
                        </th>

                        <th class="px-4 py-3 text-center">
                            Kategori
                        </th>

                        <th class="px-4 py-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @foreach ($menus as $menu)

                    <tr>

                        <!-- No -->
                        <td class="px-4 py-3 text-center">
                            {{ $loop->iteration }}
                        </td>


                        <!-- Foto -->
                        <td class="px-4 py-3 text-center">

                            @if ($menu->image)

                            <img src="{{ asset('storage/'.$menu->image) }}"
                                class="w-16 h-16 rounded-xl object-cover mx-auto">

                            @else

                            <div class="w-16 h-16 rounded-xl bg-gray-100
                                        flex items-center justify-center
                                        text-xs text-gray-400 mx-auto">

                                No Image

                            </div>

                            @endif

                        </td>


                        <!-- Nama -->
                        <td class="px-4 py-3 font-semibold">
                            {{ $menu->name }}
                        </td>


                        <!-- Harga -->
                        <td class="px-4 py-3">

                            Rp {{ number_format($menu->price,0,',','.') }}

                        </td>


                        <!-- STOK -->
                        <td class="px-4 py-3 text-center">

                            @if ($menu->stok > 10)

                                <span class="inline-flex items-center
                                    px-3 py-1 rounded-full
                                    bg-green-100 text-green-700
                                    text-xs font-semibold">

                                    {{ $menu->stok }} tersedia

                                </span>

                            @elseif ($menu->stok > 0)

                                <span class="inline-flex items-center
                                    px-3 py-1 rounded-full
                                    bg-yellow-100 text-yellow-700
                                    text-xs font-semibold">

                                    {{ $menu->stok }} tersisa

                                </span>

                            @else

                                <span class="inline-flex items-center
                                    px-3 py-1 rounded-full
                                    bg-red-100 text-red-700
                                    text-xs font-semibold">

                                    Habis

                                </span>

                            @endif

                        </td>


                        <!-- Kategori -->
                        <td class="px-4 py-3 text-center">

                            {{ ucfirst($menu->category) }}

                        </td>


                        <!-- Aksi -->
                        <td class="px-4 py-3 text-center">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.menu.edit',$menu->id) }}"
                                    class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500
                                    text-white rounded text-xs transition">

                                    Edit

                                </a>


                                <form action="{{ route('admin.menu.destroy',$menu->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus menu ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600
                                        text-white rounded text-xs transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</section>
@endsection