<x-guest-layout>
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .box-enter {
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

    <div class="flex w-full flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-md relative z-10 opacity-0 box-enter flex flex-col items-center">

            <div class="mb-8 flex flex-col items-center justify-center text-center">
                <img src="{{ asset('image/Full_logo.png') }}" alt="Deqqa Pathology AI" class="h-12 w-auto">
                <div class="mt-4 text-[10px] font-medium tracking-[0.24em] text-cyan-300/80">VERIFICATION REQUIRED</div>
            </div>

            <div class="group relative w-full">

                <div
                    class="absolute -inset-1 rounded-[2.5rem] bg-gradient-to-r from-cyan-400 via-[#8B5CF6] to-cyan-300 opacity-0 blur-xl transition-all duration-700 ease-out group-hover:opacity-40 group-hover:blur-2xl z-0">
                </div>

                <div
                    class="relative z-10 rounded-3xl border border-white/[0.09] bg-[#050B14]/80 p-7 shadow-2xl backdrop-blur-xl sm:p-9 transition-colors duration-500">

                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-semibold tracking-[-0.025em] text-white">Verify your email</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-400">Thanks for signing up! Before getting started,
                            could you verify your email address by clicking on the link we just emailed to you?</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div
                            class="mb-5 rounded-xl border border-green-400/15 bg-green-400/[0.05] px-4 py-3 text-center">
                            <div class="text-xs leading-5 text-green-400">A new verification link has been sent to the
                                email address you provided.</div>
                        </div>
                    @endif

                    <div
                        class="mt-6 flex flex-col gap-4 items-center justify-between border-t border-white/[0.07] pt-6">
                        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="group/btn relative flex w-full items-center justify-center gap-3 rounded-xl bg-cyan-300 px-5 py-3.5 text-sm font-semibold text-[#061017] transition hover:bg-cyan-200">
                                <span>Resend Verification Email</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-slate-500 transition hover:text-cyan-300">
                                Log Out
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
