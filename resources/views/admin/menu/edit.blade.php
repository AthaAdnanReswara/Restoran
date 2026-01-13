@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6 mb-26">

        <div class="bg-white shadow rounded-lg overflow-hidden">

            {{-- Header --}}
            <div class="bg-yellow-400 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">✏️ Edit Menu</h2>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-6">

                {{-- Error --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Menu</label>
                        <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                            class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200" required>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Harga</label>
                        <input type="number" name="price" value="{{ old('price', $menu->price) }}" min="0"
                            class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200" required>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Kategori</label>
                        <select name="category" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200"
                            required>
                            <option value="food" {{ $menu->category == 'food' ? 'selected' : '' }}>Makanan</option>
                            <option value="drink" {{ $menu->category == 'drink' ? 'selected' : '' }}>Minuman</option>
                            <option value="snack" {{ $menu->category == 'snack' ? 'selected' : '' }}>Snack</option>
                        </select>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Foto Menu</label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Foto Lama --}}
                            <div class="text-center">
                                <p class="text-sm font-semibold mb-2">Foto Lama</p>
                                @if ($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}"
                                        class="mx-auto w-36 h-36 object-cover rounded border">
                                @else
                                    <p class="text-gray-400 italic text-sm">Belum ada foto</p>
                                @endif
                            </div>

                            {{-- Preview Baru --}}
                            <div class="text-center">
                                <p class="text-sm font-semibold mb-2">Preview Foto Baru</p>
                                <img id="preview-image" class="mx-auto w-36 h-36 object-cover rounded border hidden">
                                <p id="preview-text" class="text-gray-400 italic text-sm">
                                    Belum ada foto dipilih
                                </p>
                            </div>

                        </div>

                        <input type="file" name="image" accept="image/*" class="mt-4 w-full border rounded px-3 py-2">

                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika tidak ingin mengganti foto
                        </p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-between pt-4">
                        <a href="{{ route('admin.menu.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Kembali
                        </a>

                        <button type="submit" class="px-5 py-2 bg-yellow-500 text-white rounded hover:bg-green-700">
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
