{{--
    Field form bersama untuk create & edit.
    Variabel: $post (Post baru atau Post yang diedit), $submitLabel
    old('field', $post->field): pakai input lama jika validasi gagal, kalau tidak pakai data dari database.
--}}
<div class="space-y-5">

    <div>
        <label for="title" class="block font-semibold mb-1">Judul</label>
        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" maxlength="150"
               class="w-full rounded border px-3 py-2 bg-white @error('title') border-red-500 @else border-slate-300 @enderror">
        @error('title')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block font-semibold mb-1">Isi post</label>
        <textarea id="content" name="content" rows="8"
                  class="w-full rounded border px-3 py-2 bg-white @error('content') border-red-500 @else border-slate-300 @enderror">{{ old('content', $post->content) }}</textarea>
        @error('content')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image" class="block font-semibold mb-1">Gambar (opsional)</label>

        @if ($post->image_url)
            <div class="mb-3">
                <img src="{{ $post->image_url }}" alt="Gambar saat ini" class="h-32 rounded border border-slate-200 object-cover">
                <label class="inline-flex items-center gap-2 mt-2 text-sm">
                    <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))>
                    Hapus gambar ini
                </label>
            </div>
        @endif

        <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp"
               class="block w-full text-sm">
        <p class="text-xs text-slate-500 mt-1">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
        @error('image')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="px-4 py-2 rounded bg-teal-700 text-white font-semibold hover:bg-teal-800">{{ $submitLabel }}</button>
        <a href="{{ route('posts.index') }}" class="px-4 py-2 rounded border border-slate-300 bg-white font-semibold hover:bg-slate-50">Batal</a>
    </div>
</div>
