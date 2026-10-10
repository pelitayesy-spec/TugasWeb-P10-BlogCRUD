{{-- Komponen Alert: <x-alert type="success">Pesan</x-alert> --}}
@props(['type' => 'info'])

@php
    $styles = [
        'success' => 'bg-green-50 border-green-500 text-green-800',
        'error'   => 'bg-red-50 border-red-500 text-red-800',
        'info'    => 'bg-sky-50 border-sky-500 text-sky-800',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'border-l-4 rounded p-4 mb-6 ' . ($styles[$type] ?? $styles['info'])]) }} role="alert">
    {{ $slot }}
</div>
