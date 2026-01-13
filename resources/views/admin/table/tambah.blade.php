@extends('layouts.app')

@section('title', 'Tambah Meja')

@section('content')
<section class="mt-6 px-4 pb-20 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            ➕ Tambah Meja
        </h2>
        <div class="h-1 w-24 bg-yellow-500 rounded mt-2"></div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border p-5 sm:p-6">

        {{-- Error --}}
        @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.table.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Nomor Meja -->
                <div>
                    <label class="block font-semibold mb-1">
                        Nomor Meja
                    </label>
                    <input type="number"
                        name="table_number"
                        value="{{ old('table_number') }}"
                        placeholder="Contoh: 1"
                        class="w-full rounded-xl border-gray-300
                                  focus:border-yellow-500 focus:ring-yellow-500"
                        required>
                </div>

                <!-- Status -->
                <div>
                    <label class="block font-semibold mb-1">
                        Status Meja
                    </label>
                    <select name="status"
                        class="w-full rounded-xl border-gray-300
                                   focus:border-yellow-500 focus:ring-yellow-500">
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                    </select>
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-between gap-3 pt-4">
                <a href="{{ route('admin.table.index') }}"
                    class="text-center rounded-xl bg-gray-200 hover:bg-gray-300
                          px-5 py-2 font-semibold transition">
                    Kembali
                </a>

                <button type="submit"
                    class="rounded-xl bg-yellow-500 hover:bg-yellow-600
                               px-6 py-2 text-white font-semibold transition">
                    Simpan Meja
                </button>
            </div>

        </form>
    </div>
</section>
@endsection