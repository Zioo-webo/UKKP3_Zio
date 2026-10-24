
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold tracking-tight">Tambah pengaduan</h1>
                <p class="mt-1 text-sm text-stone-500">Isi data pelapor dan deskripsi laporan.</p>
            </div>

            <div class="max-w-2xl">
                @include('pengaduan._form')
            </div>
        </div>
    </div>

    

</x-app-layout>
