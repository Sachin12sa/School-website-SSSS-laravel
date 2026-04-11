@extends('layouts.app')
@section('title', 'Admissions')
@section('meta_description', 'Apply for admission to ' . \App\Models\SiteSetting::get('school_name', 'Our School') . '.
    Admissions open for 2026–27.')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'Admissions',
        'title' => 'Apply to SSSS',
        'subtitle' =>
            'Join our community of learners and begin a journey of excellence, character, and human values.',
    ])

    {{-- ── PROCESS STEPS ────────────────────────────────────────────────────────── --}}
    <section class="py-16 bg-white" id="process">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Admission Process</h2>
                <div class="w-10 h-0.5 bg-gold mx-auto rounded-full"></div>
            </div>

            {{-- Steps --}}
            <div class="relative">
                {{-- Connector line (desktop) --}}
                <div class="hidden md:block absolute top-8 h-0.5 bg-gradient-to-r from-red-400 via-gold to-green-500"
                    style="left:12%;right:12%"></div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 relative">
                    @foreach ([['📋', 'Step 1', 'Collect Form', 'Get the admission form from our office or download from website', '#e53e3e'], ['📄', 'Step 2', 'Submit Documents', 'Submit completed form with all required documents before the deadline', '#d97706'], ['📅', 'Step 3', 'Entrance Test', 'Appear for entrance examination (applicable for Grades 1–12)', '#1a237e'], ['✅', 'Step 4', 'Admission Confirmation', 'Receive admission letter and complete enrolment formalities', '#059669']] as [$icon, $step, $title, $desc, $color])
                        <div class="text-center relative">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4 shadow-lg border-4 border-white"
                                style="background:{{ $color }}">{{ $icon }}</div>
                            <div class="text-[10px] font-bold text-gray-400 tracking-widest uppercase mb-1">
                                {{ $step }}</div>
                            <h4 class="font-display font-bold text-navy text-sm mb-2">{{ $title }}</h4>
                            <p class="text-gray-500 text-xs leading-relaxed">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ── ONLINE APPLICATION FORM ──────────────────────────────────────────────── --}}
    <section class="py-14 bg-gray-50" id="form">
        <div class="max-w-3xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Online Application Form</h2>
                <div class="w-10 h-0.5 bg-gold mx-auto mb-3 rounded-full"></div>
                <p class="text-gray-500 text-sm">Complete this form to apply for admission (2026–27)</p>
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-2xl p-5 mb-8 flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="font-bold">Application Submitted!</p>
                        <p class="text-sm mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Multi-step form with Alpine --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden" x-data="{ step: 1, maxStep: 3 }">

                {{-- Step indicator tabs --}}
                <div class="grid grid-cols-3 border-b border-gray-100">
                    @foreach ([[1, 'Student Info'], [2, 'Guardian Info'], [3, 'Academic Details']] as [$n, $label])
                        <div :class="step >= {{ $n }} ? 'border-navy text-navy' : 'border-transparent text-gray-400'"
                            class="py-4 text-center text-xs font-bold border-b-2 transition-colors cursor-pointer"
                            @click="step >= {{ $n }} ? step = {{ $n }} : null">
                            <div :class="step >= {{ $n }} ? 'bg-navy text-white' : 'bg-gray-100 text-gray-400'"
                                class="w-7 h-7 rounded-full flex items-center justify-center mx-auto mb-1 text-xs font-bold transition-colors">
                                {{ $n }}
                            </div>
                            <span class="hidden sm:inline">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('admissions.store') }}" method="POST" class="p-7 lg:p-10">
                    @csrf

                    {{-- ── STEP 1: Student Information ── --}}
                    <div x-show="step === 1">
                        <div class="flex items-center gap-3 mb-7 p-4 bg-navy/5 rounded-xl">
                            <div
                                class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white text-base shrink-0">
                                👤</div>
                            <div>
                                <div class="font-display font-bold text-navy text-sm">Student Information</div>
                                <div class="text-gray-400 text-xs">Personal details of the applicant</div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">First
                                        Name <span class="text-red-400">*</span></label>
                                    <input type="text" name="applicant_first_name"
                                        value="{{ old('applicant_first_name') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy"
                                        placeholder="Student's first name">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Last
                                        Name <span class="text-red-400">*</span></label>
                                    <input type="text" name="applicant_last_name"
                                        value="{{ old('applicant_last_name') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy"
                                        placeholder="Student's last name">
                                </div>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Date
                                        of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Gender</label>
                                    <select name="gender"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-navy/20">
                                        <option value="">Select…</option>
                                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Nationality</label>
                                    <input type="text" name="nationality" value="{{ old('nationality', 'Nepali') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Religion
                                        <span class="text-gray-400 font-normal">(optional)</span></label>
                                    <input type="text" name="religion" value="{{ old('religion') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Permanent
                                    Address</label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy"
                                    placeholder="Full residential address">
                            </div>
                        </div>

                        <div class="mt-7 flex justify-end">
                            <button type="button" @click="step = 2"
                                class="bg-navy hover:bg-gold text-white font-bold px-8 py-3 rounded-xl text-sm transition-colors">
                                Next: Guardian Info →
                            </button>
                        </div>
                    </div>

                    {{-- ── STEP 2: Guardian Information ── --}}
                    <div x-show="step === 2" x-cloak>
                        <div class="flex items-center gap-3 mb-7 p-4 bg-navy/5 rounded-xl">
                            <div
                                class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white text-base shrink-0">
                                👨‍👩‍👧</div>
                            <div>
                                <div class="font-display font-bold text-navy text-sm">Guardian Information</div>
                                <div class="text-gray-400 text-xs">Parent or legal guardian details</div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Parent /
                                        Guardian Name <span class="text-red-400">*</span></label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy @error('parent_name') border-red-300 @enderror">
                                    @error('parent_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Relationship</label>
                                    <select name="relationship"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-navy/20">
                                        <option>Father</option>
                                        <option>Mother</option>
                                        <option>Guardian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Email
                                        Address <span class="text-red-400">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy @error('email') border-red-300 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Phone
                                        Number <span class="text-red-400">*</span></label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy @error('phone') border-red-300 @enderror">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Occupation</label>
                                    <input type="text" name="occupation" value="{{ old('occupation') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Annual
                                        Income (NRS)</label>
                                    <input type="text" name="income" value="{{ old('income') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                            </div>
                        </div>

                        <div class="mt-7 flex justify-between">
                            <button type="button" @click="step = 1"
                                class="border border-gray-200 text-gray-600 px-6 py-3 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors">
                                ← Back
                            </button>
                            <button type="button" @click="step = 3"
                                class="bg-navy hover:bg-gold text-white font-bold px-8 py-3 rounded-xl text-sm transition-colors">
                                Next: Academic Details →
                            </button>
                        </div>
                    </div>

                    {{-- ── STEP 3: Academic Details + Submit ── --}}
                    <div x-show="step === 3" x-cloak>
                        <div class="flex items-center gap-3 mb-7 p-4 bg-navy/5 rounded-xl">
                            <div
                                class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white text-base shrink-0">
                                📚</div>
                            <div>
                                <div class="font-display font-bold text-navy text-sm">Academic Details</div>
                                <div class="text-gray-400 text-xs">Previous education and class applying for</div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Class
                                    Applying For <span class="text-red-400">*</span></label>
                                <select name="class_applying" required
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy @error('class_applying') border-red-300 @enderror">
                                    <option value="">Select a class…</option>
                                    @foreach (['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', '+2 Science', '+2 Management'] as $cls)
                                        <option value="{{ $cls }}"
                                            {{ old('class_applying') === $cls ? 'selected' : '' }}>{{ $cls }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_applying')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Previous
                                        School</label>
                                    <input type="text" name="previous_school" value="{{ old('previous_school') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Last
                                        Class / Grade</label>
                                    <input type="text" name="last_class" value="{{ old('last_class') }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Additional
                                    Message <span class="text-gray-400 font-normal">(optional)</span></label>
                                <textarea name="message" rows="4"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy resize-none"
                                    placeholder="Any special requirements or questions…">{{ old('message') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-7 flex justify-between">
                            <button type="button" @click="step = 2"
                                class="border border-gray-200 text-gray-600 px-6 py-3 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors">
                                ← Back
                            </button>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold px-10 py-3 rounded-xl text-sm transition-colors shadow-md flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Submit Application
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

    {{-- ── REQUIRED DOCUMENTS ───────────────────────────────────────────────────── --}}
    <section class="py-14 bg-white" id="documents">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Required Documents</h2>
                <div class="w-10 h-0.5 bg-gold mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([['Primary Level (1–5)', '#d97706', ['Birth certificate (original + copy)', 'Recent passport photos (4 copies)', 'Previous school report card', 'Transfer certificate (if applicable)', 'Character certificate', 'Medical fitness certificate']], ['Secondary Level (6–10)', '#1a237e', ['Mark sheets of previous classes', 'Transfer certificate from previous school', 'Character certificate', 'Birth certificate', 'Recent passport photos (4 copies)', 'Medical fitness certificate']], ['+2 Level (11–12)', '#e53e3e', ['Grade 10 mark sheet & certificate', 'Transfer certificate', 'Character certificate', 'Migration certificate (if different board)', 'Recent passport photos (4 copies)', 'Medical fitness certificate']]] as [$level, $color, $docs])
                    <div class="border-2 rounded-2xl p-6 hover:shadow-md transition-shadow"
                        style="border-color:{{ $color }}">
                        <h3 class="font-display font-bold text-lg mb-4" style="color:{{ $color }}">
                            {{ $level }}</h3>
                        <ul class="space-y-2.5">
                            @foreach ($docs as $doc)
                                <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" style="color:{{ $color }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $doc }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── IMPORTANT DATES ──────────────────────────────────────────────────────── --}}
    <section class="py-14 bg-gray-50" id="dates">
        <div class="max-w-4xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Important Dates 2026–27</h2>
                <div class="w-10 h-0.5 bg-gold mx-auto rounded-full"></div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-8 grid sm:grid-cols-2 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-5 text-red-500 font-semibold text-sm">
                        📅 Admission Timeline
                    </div>
                    @foreach ([['Form Distribution Starts', 'January 15, 2026'], ['Last Date for Submission', 'March 15, 2026'], ['Entrance Test Date', 'March 25, 2026'], ['Results Announcement', 'April 1, 2026']] as [$k, $v])
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                            <span class="text-sm text-gray-600">{{ $k }}</span>
                            <span class="text-sm font-bold text-navy">{{ $v }}</span>
                        </div>
                    @endforeach
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-5 text-gold font-semibold text-sm">
                        🗓️ Session Details
                    </div>
                    @foreach ([['Academic Year Begins', 'April 15, 2026'], ['Orientation Program', 'April 10–12, 2026'], ['Office Hours', '8:00 AM – 4:00 PM']] as [$k, $v])
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                            <span class="text-sm text-gray-600">{{ $k }}</span>
                            <span class="text-sm font-bold text-navy">{{ $v }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ── FEE STRUCTURE ────────────────────────────────────────────────────────── --}}
    <section class="py-14 bg-white" id="fees">
        <div class="max-w-4xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Fee Structure</h2>
                <div class="w-10 h-0.5 bg-gold mx-auto rounded-full"></div>
            </div>
            <div class="bg-gray-50 rounded-2xl p-8 mb-5">
                <p class="text-gray-500 text-sm mb-6 leading-relaxed">We believe in providing quality education at
                    affordable rates. Our fee structure is transparent and competitive, with provisions for scholarships and
                    fee concessions.</p>
                <h4 class="font-display font-bold text-navy mb-4 text-sm">Annual Fee Structure (2026–27)</h4>
                @foreach (['Primary Level (1–5)', 'Secondary Level (6–10)', '+2 Level (11–12)'] as $level)
                    <div class="flex justify-between items-center py-3.5 border-b border-gray-200 last:border-0">
                        <span class="text-sm text-gray-700">{{ $level }}</span>
                        <a href="{{ route('contact.index') }}"
                            class="text-sm font-bold text-navy hover:text-gold transition-colors">Contact Office →</a>
                    </div>
                @endforeach
                <p class="text-xs text-gray-400 mt-4">*Includes tuition, library, sports, and laboratory fee. Transport and
                    books are charged separately.</p>
            </div>
            <div class="bg-gold/8 border border-gold/20 rounded-xl p-5 text-sm text-gray-700">
                <strong class="text-gold">Scholarship Available:</strong> Merit-based scholarships and need-based financial
                assistance are available for eligible students. <a href="{{ route('contact.index') }}"
                    class="text-navy font-semibold hover:text-gold ml-1">Contact us for details →</a>
            </div>
        </div>
    </section>

    {{-- ── CTA ──────────────────────────────────────────────────────────────────── --}}
    <section class="py-16 text-center" style="background:linear-gradient(135deg,#1B2A4A,#16223d,#111a30)">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="font-display font-bold text-3xl text-white mb-3">Visit Our Campus</h2>
            <p class="text-white/60 mb-8">Schedule a campus tour and see our facilities, meet our teachers, and experience
                the SSSS community first-hand.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#form"
                    class="bg-gold hover:bg-gold-dark text-white font-bold px-8 py-4 rounded-xl transition-colors">Apply
                    Online Now</a>
                <a href="{{ route('contact.index') }}"
                    class="border-2 border-white/30 hover:border-gold text-white hover:text-gold font-semibold px-8 py-4 rounded-xl transition-colors">Schedule
                    a Visit</a>
            </div>
        </div>
    </section>

@endsection
