@extends('layouts.app')

@section('title', 'Semua post')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Semua post</h1>
            <p class="text-sm text-slate-500">
                {{ $posts->total() }} post
                @if (request('q')) cocok dengan "{{ request('q') }}" @endif
            </p>
        </div>
        <a href="{{ route('posts.create') }}"
           class="px-4 py-2 rounded bg-teal-700 text-white font-semibold hover:bg-teal-800">Tulis post</a>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('posts.index') }}" class="flex flex-wrap gap-2 mb-6" role="search">
        <label for="q" class="sr-only">Cari post</label>
        <input type="search" id="q" name="q" value="{{ request('q') }}" placeholder="Cari judul atau isi post"
               class="flex-1 min-w-[220px] rounded border border-slate-300 px-3 py-2 bg-white">
        <button type="submit" class="px-4 py-2 rounded border border-slate-300 bg-white font-semibold hover:bg-slate-50">Cari</button>
        @if (request('q'))
            <a href="{{ route('posts.index') }}" class="px-4 py-2 text-slate-500 hover:underline">Reset</a>
        @endif
    </form>

    @if ($posts->isEmpty())
        <x-card>
            <p class="text-center text-slate-500 py-6">
                @if (request('q'))
                    Tidak ada post yang cocok. Coba kata kunci lain.
                @else
                    Belum ada post. <a href="{{ route('posts.create') }}" class="text-teal-700 font-semibold underline">Tulis post pertama</a>.
                @endif
            </p>
        </x-card>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <x-card>
                    <x-slot name="image">
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="Gambar untuk {{ $post->title }}" class="h-40 w-full object-cover">
                        @endif
                    </x-slot>

                    <h2 class="font-bold text-lg leading-snug mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-teal-700">{{ $post->title }}</a>
                    </h2>
                    <p class="text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 110) }}</p>

                    <x-slot name="footer">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">{{ $post->created_at->format('d M Y') }}</span>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('posts.show', $post) }}" class="text-teal-700 font-semibold">Lihat</a>
                                <a href="{{ route('posts.edit', $post) }}" class="text-slate-700 font-semibold">Edit</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                      onsubmit="return confirm('Pindahkan post ini ke tempat sampah?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-card>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
