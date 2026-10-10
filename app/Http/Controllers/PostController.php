<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class PostController extends Controller
{
    private const PER_PAGE = 6;

    /** GET /posts, daftar post + pencarian + pagination */
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->search($request->query('q'))
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();   // supaya ?q= tetap ada saat pindah halaman

        return view('posts.index', compact('posts'));
    }

    /** GET /posts/create, form tambah */
    public function create(): View
    {
        return view('posts.create');
    }

    /** POST /posts, simpan post baru */
    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $path = null;

        try {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $data['image'] = $path;
            }

            Post::create($data);
        } catch (Throwable $e) {
            if ($path) {
                Storage::disk('public')->delete($path);   // jangan tinggalkan file yatim
            }
            report($e);

            return back()->withInput()->with('error', 'Post gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat.');
    }

    /** GET /posts/{post}, detail (Route Model Binding) */
    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    /** GET /posts/{post}/edit, form ubah (terisi data lama) */
    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    /** PUT /posts/{post}, simpan perubahan */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $data     = $request->safe()->except(['image', 'remove_image']);
        $oldImage = $post->image;
        $newPath  = null;

        try {
            if ($request->hasFile('image')) {
                $newPath       = $request->file('image')->store('posts', 'public');
                $data['image'] = $newPath;
            } elseif ($request->boolean('remove_image')) {
                $data['image'] = null;
            }

            $post->update($data);
        } catch (Throwable $e) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }
            report($e);

            return back()->withInput()->with('error', 'Perubahan gagal disimpan. Silakan coba lagi.');
        }

        // Hapus gambar lama hanya setelah update berhasil
        if ($oldImage && array_key_exists('image', $data)) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui.');
    }

    /** DELETE /posts/{post}, soft delete (masuk tempat sampah) */
    public function destroy(Post $post): RedirectResponse
    {
        try {
            $post->delete();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Post gagal dihapus. Silakan coba lagi.');
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post dipindahkan ke tempat sampah. Kamu bisa memulihkannya kapan saja.');
    }

    // ---------------- Bonus: soft delete ----------------

    /** GET /posts/trash, daftar post yang sudah dihapus */
    public function trash(): View
    {
        $posts = Post::onlyTrashed()->latest('deleted_at')->paginate(self::PER_PAGE);

        return view('posts.trash', compact('posts'));
    }

    /** PATCH /posts/{post}/restore */
    public function restore(Post $post): RedirectResponse
    {
        try {
            $post->restore();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Post gagal dipulihkan.');
        }

        return redirect()->route('posts.trash')->with('success', 'Post berhasil dipulihkan.');
    }

    /** DELETE /posts/{post}/force-delete, hapus permanen + file gambarnya */
    public function forceDestroy(Post $post): RedirectResponse
    {
        try {
            $image = $post->image;
            $post->forceDelete();

            if ($image) {
                Storage::disk('public')->delete($image);
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Post gagal dihapus permanen.');
        }

        return redirect()->route('posts.trash')->with('success', 'Post dihapus permanen.');
    }
}
