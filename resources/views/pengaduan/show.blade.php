<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium tracking-wide text-stone-500">{{ $pengaduan->code }}</p>
                        <h1 class="mt-1 text-2xl font-semibold tracking-tight">{{ $pengaduan->name }}</h1>
                        <p class="mt-1 text-sm text-stone-500">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="rounded-md border border-stone-300 bg-white px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">Edit</a>
                        <a href="{{ route('pengaduan.index') }}" class="rounded-md border border-stone-300 bg-white px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">Kembali</a>
                    </div>
                </div>

                <div class="max-w-3xl space-y-6 rounded-lg border border-stone-200 bg-white p-6 shadow-sm">
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Kategori</dt>
                            <dd class="mt-1">{{ $pengaduan->category->name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Telepon</dt>
                            <dd class="mt-1">{{ $pengaduan->phone }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Email</dt>
                            <dd class="mt-1">{{ $pengaduan->user->email }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Deskripsi</dt>
                            <dd class="mt-1 whitespace-pre-line">{{ $pengaduan->description }}</dd>
                        </div>
                    </dl>

                    @if ($pengaduan->pengaduan_image->isNotEmpty())
                        <div>
                            <h2 class="mb-3 text-sm font-medium">Gambar</h2>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($pengaduan->pengaduan_image as $image)
                                    <figure class="overflow-hidden rounded-md border border-stone-200">
                                        <img src="{{ asset('storage/'.$image->file_path) }}" alt="{{ $image->file_name }}" class="h-48 w-full object-cover">
                                        <figcaption class="truncate px-3 py-2 text-xs text-stone-500">{{ $image->file_name }}</figcaption>
                                    </figure>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    

</x-app-layout>
