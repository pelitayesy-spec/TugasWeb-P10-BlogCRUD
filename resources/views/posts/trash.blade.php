@extends('layouts.app')

@section('title', 'Tempat sampah')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tempat sampah</h1>
        <p class="text-sm text-slate-500">Post yang dihapus bisa dipulihkan, atau dihapus permanen beserta gambarnya.</p>
    </div>

    <x-card>
        @if ($posts->isEmpty())
            <p class="text-center text-slate-500 py-6">Tempat sampah kosong.</p>
        @else
            <div class="overflow-x-auto -m-5">
                <table class="w-full text-left text-sm min-w-[560px]">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">Dihapus</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="border-t border-slate-200">
                                <td class="px-5 py-3 font-semibold">{{ $post->title }}</td>
                                <td class="px-5 py-3 text-slate-500">{{ $post->deleted_at->diffForHumans() }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('posts.restore', $post) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-teal-700 font-semibold">Pulihkan</button>
                                        </form>
                                        <form action="{{ route('posts.force-delete', $post) }}" method="POST"
                                              onsubmit="return confirm('Hapus permanen? Data dan gambar tidak bisa dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 font-semibold">Hapus permanen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection
