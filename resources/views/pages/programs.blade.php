@extends('layouts.app')
@section('title', 'Academic Programs — SSSS')
@section('content')

    {{-- Hero --}}
    <div class="relative py-28 overflow-hidden"
        style="background:linear-gradient(135deg,rgba(26,35,126,0.88) 0%,rgba(183,28,28,0.75) 100%)">
        <div class="absolute inset-0 -z-10"><img src="https://images.unsplash.com/photo-1588072432836-e10032774350?w=1600"
                class="w-full h-full object-cover opacity-30"></div>
        <div class="max-w-3xl mx-auto px-4 text-center text-white">
            <div
                class="inline-flex items-center gap-2 bg-gold/20 border border-gold/30 text-gold text-xs font-bold px-4 py-2 rounded-full mb-6">
                <span>🎓</span> Grade 1 to +2 Level
            </div>
            <h1 class="font-display font-bold text-5xl mb-4">Academic Programs</h1>
            <p class="text-white/80 text-lg leading-relaxed">Comprehensive education from foundation to specialization,
                unlocking every student's potential</p>
        </div>
    </div>

    {{-- Stats bar --}}
    <div class="py-6" style="background:#1a237e">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ([['🎓', 'Qualified Teachers', 'Experienced educators dedicated to student success'], ['📚', 'Modern Curriculum', 'Up-to-date syllabus aligned with national standards'], ['🔬', 'Science Labs', 'Well-equipped laboratories for practical learning'], ['✅', '100% Results', 'Consistent excellence in board examinations']] as [$icon, $title, $desc])
                <div class="flex items-start gap-3 text-white">
                    <span class="text-2xl shrink-0">{{ $icon }}</span>
                    <div>
                        <div class="font-semibold text-sm">{{ $title }}</div>
                        <div class="text-white/60 text-xs mt-0.5">{{ $desc }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Explore Programs --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Explore Our Programs</h2>
                <div class="section-line mx-auto mb-4"></div>
                <p class="text-gray-500 max-w-2xl mx-auto">Choose your path — from foundational school education to
                    specialized higher secondary streams.</p>
            </div>

            {{-- Tabs --}}
            <div x-data="{ tab: 'school' }">
                <div class="flex gap-3 justify-center mb-10 flex-wrap">
                    @foreach ([['school', 'School Level'], ['science', '+2 Science'], ['management', '+2 Management']] as [$val, $label])
                        <button @click="tab='{{ $val }}'"
                            :class="tab === '{{ $val }}' ? 'btn-primary shadow-md' :
                                'border-2 border-gray-200 text-gray-600 hover:border-navy hover:text-navy'"
                            class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all">{{ $label }}</button>
                    @endforeach
                </div>

                {{-- School Level --}}
                <div x-show="tab==='school'" x-transition>
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        @foreach ([['Grades 1–5', 'Primary Level', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600', '#e53e3e'], ['Grades 6–10', 'Secondary Level', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600', '#e53e3e']] as [$badge, $title, $img, $color])
                            <div class="rounded-2xl overflow-hidden relative aspect-video shadow-lg group cursor-pointer">
                                <img src="{{ $img }}" alt="{{ $title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-6">
                                    <span class="text-xs font-bold text-white px-2.5 py-1 rounded-full w-fit mb-2"
                                        style="background:{{ $color }}">{{ $badge }}</span>
                                    <h3 class="font-display font-bold text-white text-2xl">{{ $title }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        {{-- Primary --}}
                        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <h3 class="font-display font-bold text-navy text-xl">Primary Level (Grades 1–5)</h3>
                            </div>
                            <div class="h-0.5 bg-gradient-to-r from-gold to-transparent mb-5"></div>
                            <p class="text-gray-500 text-sm mb-6">Foundation stage focusing on basic skills, creativity, and
                                moral values.</p>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach (['English', 'Mathematics', 'Science', 'Social Studies', 'Nepali/Hindi', 'Computer'] as $subj)
                                    <div class="flex items-center gap-2 text-sm text-gray-700"><svg
                                            class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>{{ $subj }}</div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Secondary --}}
                        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-3 h-3 rounded-full bg-navy-200"></div>
                                <h3 class="font-display font-bold text-navy text-xl">Secondary Level (Grades 6–10)</h3>
                            </div>
                            <div class="h-0.5 bg-gradient-to-r from-navy-200 to-transparent mb-5"></div>
                            <p class="text-gray-500 text-sm mb-6">Advanced curriculum preparing students for higher
                                secondary education.</p>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach (['English', 'Mathematics', 'Science', 'Social Studies', 'Nepali/Hindi', 'Computer Science', 'Account', 'Optional Math'] as $subj)
                                    <div class="flex items-center gap-2 text-sm text-gray-700"><svg
                                            class="w-4 h-4 text-navy-200 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>{{ $subj }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 bg-amber-50 border border-amber-100 rounded-2xl p-6">
                        <h4 class="font-display font-bold text-navy mb-4">Key Features of School Level</h4>
                        <div class="grid sm:grid-cols-2 gap-3">
                            @foreach (['Small class sizes for personalized attention', 'Regular assessments and parent-teacher meetings', 'Extra-curricular activities and sports programs', 'Character development through human values education'] as $f)
                                <div class="flex items-start gap-2 text-sm text-gray-700"><svg
                                        class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>{{ $f }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- +2 Science --}}
                <div x-show="tab==='science'" x-cloak x-transition>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="rounded-2xl overflow-hidden aspect-video shadow-lg">
                            <img src="https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=800"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                            <span class="badge-gold text-xs font-bold px-3 py-1 rounded-full">Grades 11–12</span>
                            <h3 class="font-display font-bold text-navy text-2xl mt-4 mb-3">+2 Science Stream</h3>
                            <p class="text-gray-500 text-sm mb-6 leading-relaxed">Rigorous science curriculum aligned with
                                NEB syllabus, preparing students for medical, engineering, and technical higher education.
                            </p>
                            <div class="space-y-3">
                                @foreach ([['Physics', 'Advanced mechanics, waves, optics, modern physics'], ['Chemistry', 'Organic, inorganic & physical chemistry with practicals'], ['Biology', 'Cell biology, genetics, ecology (for Med stream)'], ['Mathematics', 'Calculus, algebra, statistics (for Tech stream),'], ['English', 'Advanced language and communication'], ['Nepali', 'Regional language proficiency']] as [$s, $d])
                                    <div class="flex gap-3 items-start"><svg class="w-4 h-4 text-gold mt-0.5 shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <div class="text-sm font-semibold text-navy">{{ $s }}</div>
                                            <div class="text-xs text-gray-500">{{ $d }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- +2 Management --}}
                <div x-show="tab==='management'" x-cloak x-transition>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="rounded-2xl overflow-hidden aspect-video shadow-lg">
                            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                            <span class="bg-navy text-white text-xs font-bold px-3 py-1 rounded-full">Grades 11–12</span>
                            <h3 class="font-display font-bold text-navy text-2xl mt-4 mb-3">+2 Management Stream</h3>
                            <p class="text-gray-500 text-sm mb-6 leading-relaxed">Business and management curriculum
                                preparing students for commerce, banking, entrepreneurship, and professional fields.</p>
                            <div class="space-y-3">
                                @foreach ([['Business Studies', 'Entrepreneurship, marketing, management concepts'], ['Accountancy', 'Bookkeeping, financial statements, taxation'], ['Economics', 'Micro and macroeconomics, Nepali economy'], ['Business Mathematics', 'Statistics, financial mathematics, data analysis'], ['English', 'Advanced language and business communication'], ['Nepali', 'Regional language proficiency']] as [$s, $d])
                                    <div class="flex gap-3 items-start"><svg class="w-4 h-4 text-navy-200 mt-0.5 shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <div class="text-sm font-semibold text-navy">{{ $s }}</div>
                                            <div class="text-xs text-gray-500">{{ $d }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Beyond Academics --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Beyond Academics</h2>
                <div class="section-line mx-auto mb-4"></div>
                <p class="text-gray-500">We believe in holistic development — sports, arts, music, debates, and community
                    service.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([['Sports & Athletics', 'Cricket, Football, Basketball, Athletics, and indoor games', '#e53e3e'], ['Arts & Culture', 'Music, Dance, Drama, Art, and cultural celebrations', '#1a237e'], ['Competitions', 'Debates, Quiz, Science exhibitions, and essay writing', '#d97706']] as [$title, $desc, $color])
                    <div class="bg-white rounded-2xl p-6 border-l-4 shadow-sm" style="border-color:{{ $color }}">
                        <h3 class="font-display font-bold text-navy text-xl mb-2">{{ $title }}</h3>
                        <p class="text-gray-500 text-sm">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 text-white text-center" style="background:linear-gradient(135deg,#1a237e,#4a148c,#b71c1c)">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="font-display font-bold text-4xl mb-4">Ready to Join Us?</h2>
            <p class="text-white/80 text-lg mb-10">Discover the right program for your child. Our admissions team is here
                to guide you.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admissions.index') }}"
                    class="bg-white text-navy font-bold px-8 py-3.5 rounded-lg hover:bg-gray-100 transition-colors">Apply
                    for Admission</a>
                <a href="{{ route('contact.index') }}"
                    class="border-2 border-white/50 text-white font-semibold px-8 py-3.5 rounded-lg hover:bg-white/10 transition-colors">Contact
                    Admissions</a>
            </div>
        </div>
    </section>

@endsection
