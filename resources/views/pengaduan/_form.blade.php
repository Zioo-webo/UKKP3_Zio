@php
    $isEdit = isset($pengaduan);
@endphp

<form
    action="{{ $isEdit ? route('pengaduan.update', $pengaduan) : route('pengaduan.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-5 rounded-lg border border-stone-200 bg-white p-6 shadow-sm"
>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div>
        <label for="category_id" class="mb-1 block text-sm font-medium">Kategori</label>
        <select id="category_id" name="category_id" class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $pengaduan->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

        <div>
            <label for="phone" class="mb-1 block text-sm font-medium">Telepon</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $pengaduan->phone ?? '') }}" class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


    <div>
        <label for="description" class="mb-1 block text-sm font-medium">Deskripsi</label>
        <textarea id="description" name="description" rows="5" class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">{{ old('description', $pengaduan->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if ($isEdit && $pengaduan->pengaduan_image->isNotEmpty())
        <div>
            <p class="mb-2 text-sm font-medium">Gambar saat ini</p>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($pengaduan->pengaduan_image as $image)
                    <label class="flex items-start gap-3 rounded-md border border-stone-200 p-3">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="mt-1">
                        <span class="min-w-0">
                            <img src="{{ asset('storage/'.$image->file_path) }}" alt="{{ $image->file_name }}" class="mb-2 h-24 w-full rounded object-cover">
                            <span class="block truncate text-sm text-stone-600">{{ $image->file_name }}</span>
                            <span class="text-xs text-stone-500">Centang untuk menghapus</span>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <div>
        <label for="images" class="mb-1 block text-sm font-medium">Gambar</label>
        <input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple class="block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-stone-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-stone-800">
        <p class="mt-1 text-xs text-stone-500">Opsional. JPG, PNG, atau WEBP, maksimal 2 MB per file.</p>
        @error('images')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('images.*')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-md bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">
            {{ $isEdit ? 'Simpan perubahan' : 'Simpan' }}
        </button>
        <a href="{{ route('pengaduan.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">Batal</a>
    </div>
</form>
