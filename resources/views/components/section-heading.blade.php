@props([
    'eyebrow' => null,
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'max-w-3xl']) }}>

    @if ($eyebrow)

        <span class="section-eyebrow">
            {{ $eyebrow }}
        </span>

    @endif

    <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">
        {{ $title }}
    </h2>

    @if ($description)

        <p class="mt-5 text-base leading-8 text-slate-400 sm:text-lg">
            {{ $description }}
        </p>

    @endif

</div>