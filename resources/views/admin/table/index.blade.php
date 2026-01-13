@extends('layouts.app')

@section('title', 'Data Meja')

@section('content')
<section class="mt-6 px-4 pb-20 max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-2">
                🪑 Daftar Meja
            </h2>
            <div class="h-1 w-24 bg-yellow-500 rounded mt-2"></div>
        </div>

        <a href="{{ route('admin.table.create') }}"
            class="rounded-xl bg-yellow-500 hover:bg-yellow-600
                   px-5 py-2 text-white font-semibold transition">
            + Tambah Meja
        </a>
    </div>

    <!-- Alert -->
    @if (session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    {{-- ================= HP (CARD) ================= --}}
    <div class="grid grid-cols-1 gap-4 sm:hidden">
        @forelse ($tables as $table)
        <div class="bg-white rounded-2xl shadow border p-4">

            <div class="flex justify-between items-center mb-2">
                <h3 class="font-bold text-lg">
                    Meja {{ $table->table_number }}
                </h3>

                <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $table->status=='available'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($table->status) }}
                </span>
            </div>

            <div class="flex gap-2 mt-3">
                <a href="{{ route('admin.table.edit', $table->id) }}"
                    class="flex-1 text-center py-1 bg-yellow-400
                              text-white rounded-lg text-sm">
                    Edit
                </a>

                <form action="{{ route('admin.table.destroy', $table->id) }}"
                    method="POST"
                    class="flex-1"
                    onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                        class="w-full py-1 bg-red-500
                                   text-white rounded-lg text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-400 italic">
            Data meja belum tersedia
        </p>
        @endforelse
    </div>

    {{-- ================= LAPTOP (TABLE) ================= --}}
    <div class="hidden sm:block bg-white rounded-2xl shadow-sm border overflow-hidden mt-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3">Nomor Meja</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($tables as $table)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-center font-medium">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 font-semibold">
                            Meja {{ $table->table_number }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $table->status=='available'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($table->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.table.edit', $table->id) }}"
                                    class="px-3 py-1 bg-yellow-400
                                               hover:bg-yellow-500
                                               text-white rounded text-xs">
                                    Edit
                                </a>

                                <form action="{{ route('admin.table.destroy', $table->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1 bg-red-500
                                                   hover:bg-red-600
                                                   text-white rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4"
                            class="px-4 py-6 text-center text-gray-400 italic">
                            Data meja belum tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>
@endsection