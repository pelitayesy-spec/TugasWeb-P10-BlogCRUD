<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | Blog CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    <header class="bg-slate-900 text-white">
        <div class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('posts.index') }}" class="font-bold text-lg">Blog CRUD</a>
            <nav class="flex gap-1 text-sm" aria-label="Menu utama">
                <a href="{{ route('posts.index') }}"
                   class="px-3 py-1.5 rounded {{ request()->routeIs('posts.index', 'posts.show', 'posts.edit') ? 'bg-teal-600' : 'hover:bg-white/10' }}">Semua post</a>
                <a href="{{ route('posts.create') }}"
                   class="px-3 py-1.5 rounded {{ request()->routeIs('posts.create') ? 'bg-teal-600' : 'hover:bg-white/10' }}">Tulis post</a>
                <a href="{{ route('posts.trash') }}"
                   class="px-3 py-1.5 rounded {{ request()->routeIs('posts.trash') ? 'bg-teal-600' : 'hover:bg-white/10' }}">Tempat sampah</a>
            </nav>
        </div>
    </header>

    <main class="max-w-5xl w-full mx-auto px-4 py-8 flex-1">
        {{-- Flash message sukses / gagal --}}
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif
        @if ($errors->any())
            <x-alert type="error">Ada isian yang belum valid. Periksa pesan di bawah setiap kolom.</x-alert>
        @endif

        @yield('content')
    </main>

    <footer class="max-w-5xl w-full mx-auto px-4 py-6 text-sm text-slate-500 border-t border-slate-200">
        Tugas Rutin 10 &middot; Blog CRUD Laravel
    </footer>
</body>
</html>
