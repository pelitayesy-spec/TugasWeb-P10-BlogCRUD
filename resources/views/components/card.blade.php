{{-- Komponen Card: slot utama + slot opsional "image" dan "footer" --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden flex flex-col']) }}>
    @isset($image)
        {{ $image }}
    @endisset

    <div class="p-5 flex-1">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-5 py-3 border-t border-slate-200 bg-slate-50">
            {{ $footer }}
        </div>
    @endisset
</div>
