@extends('layouts.app')

@section('title', 'Edit post')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit post</h1>

    <x-card class="max-w-2xl">
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')   {{-- browser hanya bisa GET/POST, jadi PUT "dipalsukan" lewat field tersembunyi --}}
            @include('posts._form', ['post' => $post, 'submitLabel' => 'Simpan perubahan'])
        </form>
    </x-card>
@endsection
