<x-guest-layout subtitle="SECURE RECOVERY">

    <div class="mb-8 text-center">

        <h2 class="text-2xl font-semibold tracking-[-0.025em] text-white">
            Reset your access
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-400">
            Enter your clinical account email and we'll send you a secure reset link.
        </p>

    </div>


    <x-auth-session-status class="mb-5" :status="session('status')" />


    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" novalidate>

        @csrf

        <div>

            <label for="email" class="mb-2 block text-xs font-medium tracking-wide text-slate-300">
                Clinical email
            </label>

            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus
                autocomplete="email" placeholder="doctor@hospital.org"
                class="block w-full rounded-xl border border-white/[0.10] bg-[#0b1520] px-4 py-3.5 text-sm text-white placeholder:text-slate-600 outline-none transition focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-300/[0.07]">

            <x-auth-error-field field="email" />

        </div>


        <button type="submit"
            class="group/btn flex w-full items-center justify-center gap-3 rounded-xl bg-cyan-300 px-5 py-3.5 text-sm font-semibold text-[#061017] transition hover:bg-cyan-200">

            <span>Send secure reset link</span>

            <svg class="h-4 w-4 transition-transform group-hover/btn:translate-x-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">

                <path d="M5 12h14M13 6l6 6-6 6" />

            </svg>

        </button>

    </form>


    <div class="mt-6 border-t border-white/[0.07] pt-5 text-center">

        <a href="{{ route('login') }}" class="text-xs text-slate-500 transition hover:text-cyan-300">
            Back to clinical sign in
        </a>

    </div>

</x-guest-layout>
