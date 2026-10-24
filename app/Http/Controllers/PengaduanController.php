<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengaduanRequest;
use App\Http\Requests\UpdatePengaduanRequest;
use App\Models\Category;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            $pengaduans = Pengaduan::with('category')->latest()->get();
        } elseif ($user->hasRole('customer')) {

            $pengaduans = Pengaduan::with('category')
                ->where('user_id', $user->id)
                ->get();
        } else {

            abort(403);
        }

        return view('pengaduan.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('pengaduan.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengaduanRequest $request)
    {
        $validated = $request->validated();
        $email = User::get('email')->where('id', Auth::id());

        $pengaduan = Pengaduan::create([
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'phone'       => $validated['phone'],
            'user_id'     => Auth::id(),
            'email'       => $email,
        ]);

        $this->storeImages($request, $pengaduan);

        return redirect()
            ->route('pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil ditambahkan. Kode Anda: ' . $pengaduan->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        $pengaduan->load('pengaduan_image');
        $categories = Category::orderBy('name')->get();

        return view('pengaduan.edit', compact('pengaduan', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengaduanRequest $request, Pengaduan $pengaduan)
    {
        $validated = $request->validated();
        $email = User::get('email')->where('id', Auth::id());

        $pengaduan -> update([
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'phone'       => $validated['phone'],
            'user_id'     => Auth::id(),
            'email'       => $email,
        ]);
        $this->removeImages($request, $pengaduan);
        $this->storeImages($request, $pengaduan);

        return redirect()
            ->route('pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->load('pengaduan_image');

        foreach ($pengaduan->pengaduan_image as $image) {
            Storage::disk('public')->delete($image->file_path);
        }

        $pengaduan->delete();

        return redirect()
            ->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    private function storeImages(Request $request, Pengaduan $pengaduan): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $file) {
            $path = $file->store('pengaduan', 'public');

            $pengaduan->pengaduan_image()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }
    }

    private function removeImages(Request $request, Pengaduan $pengaduan): void
    {
        $ids = $request->input('remove_images', []);

        if ($ids === []) {
            return;
        }

        $images = $pengaduan->pengaduan_image()->whereIn('id', $ids)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->file_path);
            $image->delete();
        }
    }
}
