@props([
    'value',
    'label',
])

<div
    {{ $attributes->merge([
        'class' => 'rounded-2xl border border-white/[0.08] bg-white/[0.03] p-6 backdrop-blur-sm'
    ]) }}
>

    <div class="text-3xl font-extrabold tracking-tight text-white">
        {{ $value }}
    </div>

    <div class="mt-2 text-sm text-slate-400">
        {{ $label }}
    </div>

</div>