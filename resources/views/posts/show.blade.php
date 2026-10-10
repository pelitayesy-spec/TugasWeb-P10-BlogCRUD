@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-teal-700 font-semibold">&larr; Kembali ke daftar</a>

    <x-card class="mt-4 max-w-3xl">
        <x-slot name="image">
            @if ($post->image_url)
                <img src="{{ $post->image_url }}" alt="Gambar untuk {{ $post->title }}" class="w-full max-h-96 object-cover">
            @endif
        </x-slot>

        <h1 class="text-3xl font-bold leading-tight">{{ $post->title }}</h1>
        <p class="text-sm text-slate-500 mt-2 mb-6">
            Dibuat {{ $post->created_at->format('d M Y, H:i') }}
            @if ($post->updated_at->ne($post->created_at))
                &middot; diubah {{ $post->updated_at->diffForHumans() }}
            @endif
        </p>

        <div class="leading-relaxed">{!! nl2br(e($post->content)) !!}</div>

        <x-slot name="footer">
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('posts.edit', $post) }}" class="text-slate-700 font-semibold">Edit</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                      onsubmit="return confirm('Pindahkan post ini ke tempat sampah?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 font-semibold">Hapus</button>
                </form>
            </div>
        </x-slot>
    </x-card>
@endsection
