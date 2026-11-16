<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">
                    New Clinical Case
                </h2>
                <p class="mt-1 text-sm text-slate-400">
                    Register patient and initial case information.
                </p>
            </div>

            <a href="{{ route('cases.index') }}" class="text-sm text-slate-400 hover:text-white">
                Back to Cases
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-white/5 bg-[#050B14] p-8 shadow-2xl">

                <form method="POST" action="{{ route('cases.store') }}" class="space-y-8" novalidate>

                    @csrf

                    <div>
                        <h3 class="mb-5 text-lg font-bold text-white">
                            Patient Information
                        </h3>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            <div>
                                <label class="mb-2 block text-sm text-slate-300">
                                    Patient Name
                                </label>

                                <input type="text" name="patient_name" value="{{ old('patient_name') }}"
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">

                                @error('patient_name')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm text-slate-300">
                                    Age
                                </label>

                                <input type="number" name="age" value="{{ old('age') }}"
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">

                                @error('age')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm text-slate-300">
                                    Gender
                                </label>

                                <select name="gender"
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">
                                    <option value="">Select gender</option>
                                    <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                    <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                                </select>

                                @error('gender')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-8">

                        <h3 class="mb-5 text-lg font-bold text-white">
                            Case Information
                        </h3>

                        <div class="space-y-5">

                            <div>
                                <label class="mb-2 block text-sm text-slate-300">
                                    Specialization
                                </label>

                                <input type="text" name="specialization" value="{{ old('specialization') }}"
                                    placeholder="GI Pathology"
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">

                                @error('specialization')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="icd10" class="mb-2 block text-sm text-slate-300">
                                    ICD-10
                                </label>

                                <input id="icd10" type="text" name="icd10" value="{{ old('icd10') }}"
                                    placeholder="e.g. C18.9" maxlength="100"
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">

                                <p class="mt-2 text-xs text-slate-500">
                                    Optional clinical diagnosis or referral code.
                                </p>

                                @error('icd10')
                                    <p class="mt-2 text-sm text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm text-slate-300">
                                    Clinical Information
                                </label>

                                <textarea name="clinical_information" rows="4" placeholder="Clinical history or specimen information..."
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">{{ old('clinical_information') }}</textarea>

                                @error('clinical_information')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm text-slate-300">
                                    Number of Slides
                                </label>

                                <input type="number" name="expected_slides" value="{{ old('expected_slides', 1) }}"
                                    min="1" max="100"
                                    class="w-full rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-white focus:border-[#06B6D4] focus:outline-none">

                                <p class="mt-2 text-xs text-slate-500">
                                    Number of slides received with this case.
                                </p>

                                @error('expected_slides')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="flex justify-end border-t border-white/5 pt-6">
                        <button type="submit"
                            class="rounded-xl bg-[#06B6D4] px-6 py-3 font-bold text-[#030914] transition hover:brightness-110">
                            Create Case
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
