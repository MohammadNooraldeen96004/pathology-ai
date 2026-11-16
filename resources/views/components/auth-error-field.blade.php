@props(['field'])

@php
    $hasError = $errors->has($field);
@endphp

@if ($hasError)
    <div class="mt-2 flex items-start gap-2.5">

        {{-- Error indicator --}}
        <div
            class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full border border-red-400/40 bg-red-400/[0.06]">
            <svg class="h-2.5 w-2.5 text-red-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">

                <path d="M12 7v5" />
                <path d="M12 16h.01" />

            </svg>
        </div>


        {{-- Message --}}
        <p class="text-xs leading-5 text-red-300/90">
            {{ $errors->first($field) }}
        </p>

    </div>
@endif
