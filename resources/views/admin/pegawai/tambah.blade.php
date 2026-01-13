@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <section class="mt-6 px-4 max-w-3xl mx-auto pb-20">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                ➕ Tambah Pegawai
            </h2>
            <div class="h-1 w-60 bg-yellow-500 rounded mt-2"></div>
            <p class="text-gray-600 mt-2 text-sm">
                Tambahkan akun pegawai baru untuk mengelola sistem.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border p-6">

            <!-- Error -->
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.pegawai.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama pegawai"
                        class="w-full rounded-xl border-gray-300 px-4 py-2
                              focus:border-yellow-500 focus:ring-yellow-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                        class="w-full rounded-xl border-gray-300 px-4 py-2
                              focus:border-yellow-500 focus:ring-yellow-500">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border-gray-300 px-4 py-2
                              focus:border-yellow-500 focus:ring-yellow-500">
                </div>

                <!-- Action -->
                <div class="flex flex-col sm:flex-row gap-3 justify-between pt-4">
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="inline-flex justify-center items-center rounded-xl
                          border border-gray-300 px-5 py-2 text-gray-700
                          hover:bg-gray-100 transition">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="inline-flex justify-center items-center rounded-xl
                               bg-yellow-500 hover:bg-yellow-600
                               px-6 py-2 text-white font-semibold transition">
                        Simpan Pegawai
                    </button>
                </div>

            </form>
        </div>

    </section>
@endsection
