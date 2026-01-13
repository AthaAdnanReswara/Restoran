@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
<section class="mt-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-24">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h3 class="text-xl sm:text-2xl font-bold flex items-center gap-2">
            👨‍💼 Data Pegawai
        </h3>

        <a href="{{ route('admin.pegawai.create') }}"
            class="inline-flex items-center justify-center
                  bg-yellow-500 hover:bg-yellow-600
                  text-white font-semibold
                  px-5 py-2 rounded-xl transition">
            + Tambah Pegawai
        </a>
    </div>

    <!-- ALERT -->
    @if(session('success'))
    <div class="mb-4 rounded-xl bg-green-100 text-green-800 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- ================= MOBILE VIEW ================= -->
    <div class="space-y-4 md:hidden">
        @forelse ($pegawais as $pegawai)
        <div class="bg-white rounded-2xl shadow border p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="font-semibold text-base">{{ $pegawai->name }}</p>
                    <p class="text-xs text-gray-500 break-all">{{ $pegawai->email }}</p>
                </div>

                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                 bg-blue-100 text-blue-700">
                    Pegawai
                </span>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}"
                    class="flex-1 text-center
                              bg-yellow-500 hover:bg-yellow-600
                              text-white py-2 rounded-lg
                              text-sm font-semibold">
                    Edit
                </a>

                <form action="{{ route('admin.pegawai.destroy', $pegawai->id) }}"
                    method="POST"
                    class="flex-1"
                    onsubmit="return confirm('Yakin hapus pegawai ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                        class="w-full bg-red-500 hover:bg-red-600
                                   text-white py-2 rounded-lg
                                   text-sm font-semibold">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500 text-sm">
            Data pegawai belum ada
        </p>
        @endforelse
    </div>

    <!-- ================= DESKTOP VIEW ================= -->
    <div class="hidden md:block bg-white rounded-2xl shadow border overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-center">Role</th>
                    <th class="px-4 py-3 text-center w-48">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($pegawais as $pegawai)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium">
                        {{ $pegawai->name }}
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $pegawai->email }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                         bg-blue-100 text-blue-700">
                            Pegawai
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600
                                          text-white px-4 py-1.5
                                          rounded-lg text-sm font-semibold">
                                Edit
                            </a>

                            <form action="{{ route('admin.pegawai.destroy', $pegawai->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin hapus pegawai ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-500 hover:bg-red-600
                                               text-white px-4 py-1.5
                                               rounded-lg text-sm font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                        Data pegawai belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</section>
@endsection