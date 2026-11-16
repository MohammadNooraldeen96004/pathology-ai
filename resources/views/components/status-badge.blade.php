@props(['status'])

@php
    $styles = match ($status) {
        'completed' => [
            'wrapper' => 'bg-emerald-500/10 text-emerald-400',
            'dot' => 'bg-emerald-400',
            'label' => 'Completed',
        ],

        'processing' => [
            'wrapper' => 'bg-[#06B6D4]/10 text-[#06B6D4]',
            'dot' => 'bg-[#06B6D4]',
            'label' => 'Processing',
        ],

        default => [
            'wrapper' => 'bg-yellow-500/10 text-yellow-500',
            'dot' => 'bg-yellow-500',
            'label' => 'Pending',
        ],
    };
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium {{ $styles['wrapper'] }}">
    <span class="h-1.5 w-1.5 rounded-full {{ $styles['dot'] }}"></span>

    {{ $styles['label'] }}
</span>
