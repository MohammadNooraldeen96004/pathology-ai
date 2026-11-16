<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="mb-1 flex items-center gap-2 text-xs font-medium uppercase tracking-[0.16em] text-slate-500">
                    <span>Clinical Case</span>
                    <span>/</span>
                    <span class="text-[#06B6D4]">{{ $case->case_number }}</span>
                </div>

                <h2 class="text-2xl font-bold tracking-tight text-white">
                    Edit Case
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Update patient and clinical intake information.
                </p>
            </div>

            <a href="{{ route('cases.show', $case) }}"
                class="text-sm font-medium text-slate-400 transition hover:text-white">
                ← Back to Workspace
            </a>

        </div>
    </x-slot>


    <div class="py-12">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <form method="POST"
                action="{{ route('cases.update', [
                    'case' => $case,
                    'search' => request('search'),
                    'status' => request('status'),
                    'page' => request('page'),
                ]) }}"
                novalidate>

                @csrf
                @method('PATCH')


                {{-- System Identifiers --}}
                <div class="mb-6 rounded-2xl border border-white/5 bg-[#050B14] p-6">

                    <div class="mb-5">
                        <h3 class="font-bold text-white">
                            Case Identifiers
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            System-generated identifiers cannot be edited.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        <div>
                            <p class="mb-2 text-xs font-medium uppercase tracking-wider text-slate-500">
                                Case Number
                            </p>

                            <div
                                class="rounded-xl border border-white/[0.07] bg-[#0B1520]/60 px-4 py-3 font-mono text-sm text-[#06B6D4]">
                                {{ $case->case_number }}
                            </div>
                        </div>

                        <div>
                            <p class="mb-2 text-xs font-medium uppercase tracking-wider text-slate-500">
                                Patient Code
                            </p>

                            <div
                                class="rounded-xl border border-white/[0.07] bg-[#0B1520]/60 px-4 py-3 font-mono text-sm text-slate-300">
                                {{ $case->patient->patient_code }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- Patient Information --}}
                <div class="mb-6 rounded-2xl border border-white/5 bg-[#050B14] p-6 sm:p-8">

                    <div class="mb-6 border-b border-white/5 pb-5">
                        <h3 class="text-lg font-bold text-white">
                            Patient Information
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Update the patient's demographic information.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Name --}}
                        <div class="md:col-span-2">

                            <label for="patient_name" class="mb-2 block text-sm font-medium text-slate-300">
                                Patient Name
                            </label>

                            <input id="patient_name" type="text" name="patient_name"
                                value="{{ old('patient_name', $case->patient->name) }}" @class([
                                    'w-full rounded-xl border bg-[#0B1520] px-4 py-3 text-sm text-white outline-none transition',
                                    'border-red-400/70 focus:border-red-400 focus:ring-4 focus:ring-red-400/[0.08]' => $errors->has(
                                        'patient_name'),
                                    'border-white/10 focus:border-[#06B6D4] focus:ring-4 focus:ring-cyan-400/[0.06]' => !$errors->has(
                                        'patient_name'),
                                ])>

                            @error('patient_name')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Age --}}
                        <div>

                            <label for="age" class="mb-2 block text-sm font-medium text-slate-300">
                                Age
                            </label>

                            <input id="age" type="number" name="age" min="0" max="120"
                                value="{{ old('age', $case->patient->age) }}" @class([
                                    'w-full rounded-xl border bg-[#0B1520] px-4 py-3 text-sm text-white outline-none transition',
                                    'border-red-400/70 focus:border-red-400' => $errors->has('age'),
                                    'border-white/10 focus:border-[#06B6D4]' => !$errors->has('age'),
                                ])>

                            @error('age')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Gender --}}
                        <div>

                            <label for="gender" class="mb-2 block text-sm font-medium text-slate-300">
                                Gender
                            </label>

                            <select id="gender" name="gender" @class([
                                'w-full rounded-xl border bg-[#0B1520] px-4 py-3 text-sm text-white outline-none transition',
                                'border-red-400/70 focus:border-red-400' => $errors->has('gender'),
                                'border-white/10 focus:border-[#06B6D4]' => !$errors->has('gender'),
                            ])>

                                <option value="">Select gender</option>

                                <option value="Male" @selected(old('gender', $case->patient->gender) === 'Male')>
                                    Male
                                </option>

                                <option value="Female" @selected(old('gender', $case->patient->gender) === 'Female')>
                                    Female
                                </option>

                            </select>

                            @error('gender')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Case Information --}}
                <div class="rounded-2xl border border-white/5 bg-[#050B14] p-6 sm:p-8">

                    <div class="mb-6 border-b border-white/5 pb-5">
                        <h3 class="text-lg font-bold text-white">
                            Case Information
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Update the initial clinical information associated with this case.
                        </p>
                    </div>

                    <div class="space-y-6">

                        {{-- Specialization --}}
                        <div>

                            <label for="specialization" class="mb-2 block text-sm font-medium text-slate-300">
                                Specialization
                            </label>

                            <input id="specialization" type="text" name="specialization"
                                value="{{ old('specialization', $case->specialization) }}"
                                placeholder="e.g. GI Pathology" @class([
                                    'w-full rounded-xl border bg-[#0B1520] px-4 py-3 text-sm text-white placeholder:text-slate-600 outline-none transition',
                                    'border-red-400/70 focus:border-red-400' => $errors->has('specialization'),
                                    'border-white/10 focus:border-[#06B6D4]' => !$errors->has('specialization'),
                                ])>

                            @error('specialization')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>
                        <div>
                            <label for="icd10" class="mb-2 block text-sm font-medium text-slate-300">
                                ICD-10
                            </label>

                            <input id="icd10" type="text" name="icd10" maxlength="100"
                                value="{{ old('icd10', $case->icd10) }}" placeholder="e.g. C18.9"
                                @class([
                                    'w-full rounded-xl border bg-[#0B1520] px-4 py-3 text-sm text-white placeholder:text-slate-600 outline-none transition',
                                    'border-red-400/70 focus:border-red-400' => $errors->has('icd10'),
                                    'border-white/10 focus:border-[#06B6D4]' => !$errors->has('icd10'),
                                ])>

                            @error('icd10')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Clinical Information --}}
                        <div>

                            <label for="clinical_information" class="mb-2 block text-sm font-medium text-slate-300">
                                Clinical Information
                            </label>

                            <textarea id="clinical_information" name="clinical_information" rows="5"
                                placeholder="Clinical history, specimen information, relevant notes..." @class([
                                    'w-full resize-y rounded-xl border bg-[#0B1520] px-4 py-3 text-sm leading-6 text-white placeholder:text-slate-600 outline-none transition',
                                    'border-red-400/70 focus:border-red-400' => $errors->has(
                                        'clinical_information'),
                                    'border-white/10 focus:border-[#06B6D4]' => !$errors->has(
                                        'clinical_information'),
                                ])>{{ old('clinical_information', $case->additional_info) }}</textarea>

                            @error('clinical_information')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Expected Slides --}}
                        <div>

                            <label for="expected_slides" class="mb-2 block text-sm font-medium text-slate-300">
                                Number of Slides
                            </label>

                            <input id="expected_slides" type="number" name="expected_slides" min="1"
                                max="120" value="{{ old('expected_slides', $case->expected_slides) }}"
                                @class([
                                    'w-full rounded-xl border bg-[#0B1520] px-4 py-3 text-sm text-white outline-none transition',
                                    'border-red-400/70 focus:border-red-400' => $errors->has('expected_slides'),
                                    'border-white/10 focus:border-[#06B6D4]' => !$errors->has(
                                        'expected_slides'),
                                ])>

                            <p class="mt-2 text-xs text-slate-500">
                                Total number of slides received for this clinical case.
                            </p>

                            @error('expected_slides')
                                <p class="mt-2 text-xs text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- Diagnostic Documentation --}}
                    <div class="mt-6 rounded-2xl border border-white/5 bg-[#050B14] p-6 sm:p-8">

                        <div class="mb-6 border-b border-white/5 pb-5">
                            <h3 class="text-lg font-bold text-white">
                                Diagnostic Documentation
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Document the pathology workflow and final case interpretation.
                            </p>
                        </div>

                        <div class="space-y-6">

                            {{-- Grossing --}}
                            <div>
                                <label for="grossing" class="mb-2 block text-sm font-medium text-slate-300">
                                    Grossing
                                </label>

                                <textarea id="grossing" name="grossing" rows="4" maxlength="5000"
                                    placeholder="Macroscopic specimen description..."
                                    class="w-full resize-y rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-sm leading-6 text-white placeholder:text-slate-600 outline-none transition focus:border-[#06B6D4]">{{ old('grossing', $case->grossing) }}</textarea>

                                @error('grossing')
                                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Microscopy --}}
                            <div>
                                <label for="micro_protocol" class="mb-2 block text-sm font-medium text-slate-300">
                                    Microscopy Protocol
                                </label>

                                <textarea id="micro_protocol" name="micro_protocol" rows="4" maxlength="5000"
                                    placeholder="Microscopic examination findings or protocol..."
                                    class="w-full resize-y rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-sm leading-6 text-white placeholder:text-slate-600 outline-none transition focus:border-[#06B6D4]">{{ old('micro_protocol', $case->micro_protocol) }}</textarea>

                                @error('micro_protocol')
                                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Differential Diagnosis --}}
                            <div>
                                <label for="diff_diagnostic" class="mb-2 block text-sm font-medium text-slate-300">
                                    Differential Diagnosis
                                </label>

                                <textarea id="diff_diagnostic" name="diff_diagnostic" rows="4" maxlength="5000"
                                    placeholder="Possible differential diagnoses..."
                                    class="w-full resize-y rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-sm leading-6 text-white placeholder:text-slate-600 outline-none transition focus:border-[#06B6D4]">{{ old('diff_diagnostic', $case->diff_diagnostic) }}</textarea>

                                @error('diff_diagnostic')
                                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Diagnosis --}}
                            <div>
                                <label for="diagnosis" class="mb-2 block text-sm font-medium text-slate-300">
                                    Diagnosis
                                </label>

                                <textarea id="diagnosis" name="diagnosis" rows="4" maxlength="5000"
                                    placeholder="Final pathological diagnosis..."
                                    class="w-full resize-y rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-sm leading-6 text-white placeholder:text-slate-600 outline-none transition focus:border-[#06B6D4]">{{ old('diagnosis', $case->diagnosis) }}</textarea>

                                @error('diagnosis')
                                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Conclusion --}}
                            <div>
                                <label for="conclusion" class="mb-2 block text-sm font-medium text-slate-300">
                                    Conclusion
                                </label>

                                <textarea id="conclusion" name="conclusion" rows="4" maxlength="5000"
                                    placeholder="Final integrated case conclusion..."
                                    class="w-full resize-y rounded-xl border border-white/10 bg-[#0B1520] px-4 py-3 text-sm leading-6 text-white placeholder:text-slate-600 outline-none transition focus:border-[#06B6D4]">{{ old('conclusion', $case->conclusion) }}</textarea>

                                @error('conclusion')
                                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>
                    {{-- Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3 border-t border-white/5 pt-6 sm:flex-row sm:justify-end">

                        <a href="{{ route('cases.show', $case) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-white/10 px-5 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-[#06B6D4] px-6 py-3 text-sm font-bold text-[#030914] shadow-[0_0_20px_rgba(6,182,212,0.12)] transition hover:brightness-110">
                            Save Changes
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
