<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-end">
                    <a href="{{ route('pengaduan.create') }}" class="py-2.5 px-5 bg-sky-800 text-white rounded-xl text-xs font-semibold uppercase tracking-widest hover:bg-sky-700 duration-300 hover:py-3">Create Data</a>
                </div>
            </div>

            {{-- Data table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Daftar Pengaduan
                        </h3>
                        <button onclick="window.print()" class="no-print py-2 px-4 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg text-xs font-semibold uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 duration-300">
                            Print
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Kode</th>
                                    <th class="px-4 py-3">Pelapor</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Deskripsi</th>
                                    <th class="px-4 py-3">Telepon</th>
                                    <th class="px-4 py-3">Gambar</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3 no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($pengaduans as $pengaduan)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $pengaduan->code }}</td>
                                        <td class="px-4 py-3">{{ $pengaduan->user->name ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $pengaduan->category->name ?? '-' }}</td>
                                        <td class="px-4 py-3 max-w-xs truncate" title="{{ $pengaduan->description }}">
                                            {{ $pengaduan->description }}
                                        </td>
                                        <td class="px-4 py-3">{{ $pengaduan->phone }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-1">
                                                @foreach ($pengaduan->pengaduan_image as $image)
                                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                                        alt="{{ $image->file_name }}"
                                                        class="w-12 h-12 object-cover rounded">
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ $pengaduan->created_at->format('d M Y H:i') }}
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-4 py-3 whitespace-nowrap no-print">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('pengaduan.show', $pengaduan) }}"
                                                class="py-1.5 px-3 bg-sky-800 text-white rounded-lg text-xs font-semibold hover:bg-sky-700 duration-300">
                                                    Detail
                                                </a>
                                                <a href="{{ route('pengaduan.edit', $pengaduan) }}"
                                                class="py-1.5 px-3 bg-amber-500 text-white rounded-lg text-xs font-semibold hover:bg-amber-400 duration-300">
                                                    Edit
                                                </a>

                                                <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="py-1.5 px-3 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-500 duration-300">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                            Belum ada data pengaduan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            .no-print,
            nav { display: none !important; }
        }
    </style>
</x-app-layout>