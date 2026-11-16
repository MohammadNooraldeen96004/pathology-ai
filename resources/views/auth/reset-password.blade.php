<x-guest-layout subtitle="SECURITY UPDATE">

    <div class="mb-8 text-center">

        <h2 class="text-2xl font-semibold tracking-[-0.025em] text-white">
            New password
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-400">
            Please enter your new secure password below to regain access.
        </p>

    </div>


    <form method="POST" action="{{ route('password.store') }}" class="space-y-5" novalidate>

        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        
        {{-- إيميل مخفي: مطلوب برمجياً للارافل بس ما بيظهر للمستخدم --}}
        <input type="hidden" name="email" value="{{ old('email', request()->email) }}">


        {{-- New Password --}}

        <div>

            <label for="password" class="mb-2 block text-xs font-medium tracking-wide text-slate-300">
                New password
            </label>

            <input id="password" type="password" name="password" autofocus autocomplete="new-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border border-white/[0.10] bg-[#0b1520] px-4 py-3.5 text-sm text-white placeholder:text-slate-600 outline-none transition focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-300/[0.07]">

            <x-auth-error-field field="password" />

        </div>


        {{-- Confirm Password --}}

        <div>

            <label for="password_confirmation" class="mb-2 block text-xs font-medium tracking-wide text-slate-300">
                Confirm password
            </label>

            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border border-white/[0.10] bg-[#0b1520] px-4 py-3.5 text-sm text-white placeholder:text-slate-600 outline-none transition focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-300/[0.07]">

            <x-auth-error-field field="password_confirmation" />

        </div>


        <button type="submit"
            class="mt-2 flex w-full items-center justify-center gap-3 rounded-xl bg-cyan-300 px-5 py-3.5 text-sm font-semibold text-[#061017] transition hover:bg-cyan-200">

            Set New Password

        </button>

    </form>

</x-guest-layout>
