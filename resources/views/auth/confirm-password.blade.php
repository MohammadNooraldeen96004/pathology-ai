<x-guest-layout subtitle="SECURE AREA">

    <div class="mb-8 text-center">

        <h2 class="text-2xl font-semibold tracking-[-0.025em] text-white">
            Confirm Password
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-400">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>

    </div>


    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">

        @csrf

        <div>

            <label for="password" class="mb-2 block text-xs font-medium tracking-wide text-slate-300">
                Password
            </label>

            <input id="password" type="password" name="password" required autofocus autocomplete="current-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border border-white/[0.10] bg-[#0b1520] px-4 py-3.5 text-sm text-white placeholder:text-slate-600 outline-none transition focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-300/[0.07]">

            <x-form-error :messages="$errors->get('password')" />

        </div>


        <button type="submit"
            class="flex w-full items-center justify-center gap-3 rounded-xl bg-cyan-300 px-5 py-3.5 text-sm font-semibold text-[#061017] transition hover:bg-cyan-200">

            Confirm Access

        </button>

    </form>

</x-guest-layout>
