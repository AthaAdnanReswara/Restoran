@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 pb-24">

    <div class="bg-white shadow rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="bg-yellow-400 px-6 py-4">
            <h2 class="text-xl font-bold text-gray-800">✏️ Edit Menu</h2>
        </div>

        {{-- Body --}}
        <div class="p-5 sm:p-6 space-y-6">

            {{-- Error --}}
            @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- GRID FORM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Menu</label>
                        <input type="text" name="name"
                            value="{{ old('name', $menu->name) }}"
                            class="w-full rounded-xl border-gray-300
                                   focus:border-yellow-500 focus:ring-yellow-500"
                            required>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Harga</label>
                        <input type="number" name="price"
                            value="{{ old('price', $menu->price) }}"
                            class="w-full rounded-xl border-gray-300
                                   focus:border-yellow-500 focus:ring-yellow-500"
                            required>
                    </div>

                    {{-- Kategori --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-1">Kategori</label>
                        <select name="category"
                            class="w-full rounded-xl border-gray-300
                                   focus:border-yellow-500 focus:ring-yellow-500"
                            required>
                            <option value="food" {{ $menu->category=='food'?'selected':'' }}>Makanan</option>
                            <option value="drink" {{ $menu->category=='drink'?'selected':'' }}>Minuman</option>
                            <option value="snack" {{ $menu->category=='snack'?'selected':'' }}>Snack</option>
                        </select>
                    </div>

                </div>

                {{-- FOTO --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">Foto Menu</label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Foto Lama --}}
                        <div class="text-center">
                            <p class="text-sm font-semibold mb-2">Foto Lama</p>
                            @if ($menu->image)
                            <img src="{{ asset('storage/'.$menu->image) }}"
                                class="mx-auto w-32 h-32 sm:w-36 sm:h-36
                                            object-cover rounded-xl border">
                            @else
                            <p class="text-gray-400 italic text-sm">Belum ada foto</p>
                            @endif
                        </div>

                        {{-- Preview Baru --}}
                        <div class="text-center">
                            <p class="text-sm font-semibold mb-2">Preview Foto Baru</p>
                            <img id="preview-image"
                                class="mx-auto w-32 h-32 sm:w-36 sm:h-36
                                        object-cover rounded-xl border hidden">
                            <p id="preview-text" class="text-gray-400 italic text-sm">
                                Belum ada foto dipilih
                            </p>
                        </div>

                    </div>

                    <input type="file" name="image" accept="image/*"
                        class="mt-4 w-full text-sm
                               file:mr-4 file:rounded-xl
                               file:border-0 file:bg-yellow-500
                               file:px-4 file:py-2
                               file:text-white file:font-semibold
                               hover:file:bg-yellow-600 transition">

                    <p class="text-xs text-gray-500 mt-1">
                        Kosongkan jika tidak ingin mengganti foto
                    </p>
                </div>

                {{-- BUTTON --}}
                <div class="flex flex-col sm:flex-row justify-between gap-3 pt-4">
                    <a href="{{ route('admin.menu.index') }}"
                        class="text-center rounded-xl bg-gray-200 hover:bg-gray-300
                              px-5 py-2 font-semibold transition">
                        Kembali
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-yellow-500 hover:bg-yellow-600
                               px-6 py-2 text-white font-semibold transition">
                        Update Menu
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Preview Image --}}
<script>
    document.querySelector('input[name="image"]').addEventListener('change', e => {
        const img = document.getElementById('preview-image')
        const text = document.getElementById('preview-text')

        if (e.target.files[0]) {
            img.src = URL.createObjectURL(e.target.files[0])
            img.classList.remove('hidden')
            text.classList.add('hidden')
        }
    })
</script>
@endsection