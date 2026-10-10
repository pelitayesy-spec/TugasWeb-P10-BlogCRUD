@extends('layouts.app')

@section('title', 'Tulis post')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Tulis post</h1>

    <x-card class="max-w-2xl">
        {{-- enctype multipart wajib untuk upload file --}}
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @include('posts._form', ['post' => new \App\Models\Post(), 'submitLabel' => 'Simpan post'])
        </form>
    </x-card>
@endsection
