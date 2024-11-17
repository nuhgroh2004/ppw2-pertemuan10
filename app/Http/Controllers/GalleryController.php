<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Post;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar galeri dengan paginasi.
     * Data diambil dari model Post yang memiliki atribut gambar.
     */
    public function index()
    {
        $data = [
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')
                ->whereNotNull('picture')
                ->orderBy('created_at', 'desc')
                ->paginate(30)
        ];

        return view('gallery.index')->with($data);
    }

    /**
     * Menampilkan halaman untuk membuat galeri baru.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Menyimpan galeri baru ke dalam database.
     * Gambar yang diunggah disimpan ke folder penyimpanan.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('picture')) {
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }

        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Menampilkan detail galeri berdasarkan ID.
     */
    public function show(string $id)
    {
        $gallery = Post::find($id);
        return view('gallery.show', compact('gallery'));
    }
    /**
     * Menampilkan halaman untuk mengedit data galeri.
     */
    public function edit(string $id)
    {
        $gallery = Post::find($id);
        return view('gallery.update', compact('gallery'));
    }

    /**
     * Memperbarui data galeri berdasarkan input pengguna.
     * Jika ada gambar baru yang diunggah, gambar lama akan dihapus.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        $post = Post::find($id);

        if ($request->hasFile('picture')) {
            if ($post->picture && $post->picture !== 'noimage.png') {
                \Storage::delete('posts_image/' . $post->picture);
            }

            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
            $post->picture = $filenameSimpan;
        }

        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect('gallery')->with('success', 'Berhasil memperbarui data');
    }

    /**
     * Menghapus galeri dari database berdasarkan ID.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return redirect('gallery')->with('success', 'Berhasil menghapus data');
        } else {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }
    }
}
