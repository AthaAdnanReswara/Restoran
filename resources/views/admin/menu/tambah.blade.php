@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
    <section class="mt-6 px-4 pb-20 max-w-3xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                ➕ Tambah Menu
            </h2>
            <div class="h-1 w-24 bg-yellow-500 rounded mt-2"></div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border p-6">

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

            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Nama Menu -->
                <div>
                    <label class="block font-semibold mb-1">Nama Menu</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Nasi Goreng"
                        class="w-full rounded-xl border-gray-300
                              focus:border-yellow-500 focus:ring-yellow-500"
                        required>
                </div>

                <!-- Harga -->
                <div>
                    <label class="block font-semibold mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0"
                        placeholder="Contoh: 15000"
                        class="w-full rounded-xl border-gray-300
                              focus:border-yellow-500 focus:ring-yellow-500"
                        required>
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category"
                        class="w-full rounded-xl border-gray-300
                               focus:border-yellow-500 focus:ring-yellow-500"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>Makanan</option>
                        <option value="drink" {{ old('category') == 'drink' ? 'selected' : '' }}>Minuman</option>
                        <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>

                <!-- Upload Image -->
                <div>
                    <label class="block font-semibold mb-1">Foto Menu</label>

                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <input type="file" name="image" accept="image/*"
                            class="block w-full text-sm
                                  file:mr-4 file:rounded-xl
                                  file:border-0 file:bg-yellow-500
                                  file:px-4 file:py-2
                                  file:text-white file:font-semibold
                                  hover:file:bg-yellow-600 transition">

                        <!-- Preview -->
                        <img id="preview-image" class="hidden w-28 h-28 rounded-xl object-cover border">
                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Format JPG / PNG · Maks 2MB
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between pt-4">
                    <a href="{{ route('admin.menu.index') }}"
                        class="rounded-xl bg-gray-200 hover:bg-gray-300
                          px-5 py-2 font-semibold transition">
                        Kembali
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-yellow-500 hover:bg-yellow-600
                               px-6 py-2 text-white font-semibold transition">
                        Simpan Menu
                    </button>
                </div>

            </form>
        </div>
    </section>

    {{-- Preview Image Script --}}
    <script>
        document.querySelector('input[name="image"]').addEventListener('change', function(e) {
            const preview = document.getElementById('preview-image');
            const file = e.target.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
@endsection
