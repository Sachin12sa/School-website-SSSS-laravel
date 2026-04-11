@extends('layouts.app')
@section('title', 'Life at SSSS — Sathya Sai Shiksha Sadan')
@section('content')

    {{-- Hero --}}
    <div class="relative py-28 text-center overflow-hidden"
        style="background:linear-gradient(135deg,rgba(26,35,126,0.88) 0%,rgba(183,28,28,0.7) 100%)">
        <div class="absolute inset-0 -z-10"><img src="https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=1600"
                class="w-full h-full object-cover opacity-25"></div>
        <div class="max-w-3xl mx-auto px-4 text-white">
            <div
                class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-xs font-bold px-4 py-2 rounded-full mb-6">
                🌟 A Holistic Learning Environment</div>
            <h1 class="font-display font-bold text-5xl mb-4">Life at SSSS</h1>
            <p class="text-white/80 text-lg leading-relaxed">Beyond academics — a vibrant, nurturing community where students
                grow, create, and shine</p>
        </div>
    </div>

    {{-- Beyond Textbooks --}}
    <section class="py-20 bg-white text-center">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="font-display font-bold text-3xl text-navy mb-3">Beyond Textbooks</h2>
            <div class="section-line mx-auto mb-6"></div>
            <p class="text-gray-600 leading-relaxed">At Sathya Sai Shiksha Sadan, we believe in holistic education. Life at
                SSSS offers numerous opportunities for students to explore their interests, develop new skills, build
                character, and grow into well-rounded, value-driven individuals.</p>
        </div>
    </section>

    {{-- Campus Tour Video Section --}}
    <section class="py-16 bg-navy">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-display font-bold text-3xl text-white mb-3">See Life at SSSS</h2>
            <p class="text-white/70 mb-8 text-sm">Take a virtual tour of our campus and experience the vibrant learning
                community at Sathya Sai Shiksha Sadan</p>
            <div class="relative rounded-2xl overflow-hidden shadow-2xl cursor-pointer group" x-data="{ playing: false }">
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=1200" alt="Campus"
                    class="w-full aspect-video object-cover">
                <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center">
                    <div
                        class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-3 shadow-xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                        </svg>
                    </div>
                    <div class="text-white font-semibold">Watch Campus Tour</div>
                    <div class="text-white/60 text-xs mt-1">3:45 min</div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                @foreach ([['0:30', 'Morning Assembly'], ['1:00', 'Classrooms & Labs'], ['2:50', 'Sports & Activities']] as [$time, $label])
                    <div class="bg-white/10 rounded-xl p-3 text-left cursor-pointer hover:bg-white/20 transition-colors">
                        <div class="text-white/60 text-xs">{{ $time }}</div>
                        <div class="text-white text-xs font-semibold mt-0.5">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Student Activities --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Student Activities</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([['🎵', 'Music & Dance', 'Traditional and modern music, dance classes and performances', 'Weekly Classes', '#e53e3e'], ['🏆', 'Sports & Athletics', 'Cricket, Football, Basketball, Athletics, and indoor games', '10+ Sports', '#1a237e'], ['🎨', 'Arts & Craft', 'Drawing, painting, handicrafts, and creative expression', 'Art Programs', '#d97706'], ['❤️', 'Value Education', 'Daily prayers, meditation, and character development sessions', 'Daily Practice', '#e53e3e'], ['📖', 'Literary Activities', 'Debates, elocution, essay writing, and quiz competitions', 'Regular Events', '#1a237e'], ['🌏', 'Cultural Programs', 'Annual day, festivals, and cultural celebrations', 'Year-round', '#d97706']] as [$icon, $title, $desc, $tag, $color])
                    <div class="border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-shadow">
                        <div class="text-3xl mb-3">{{ $icon }}</div>
                        <h3 class="font-display font-bold text-navy text-xl mb-2">{{ $title }}</h3>
                        <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ $desc }}</p>
                        <span class="text-xs font-bold" style="color:{{ $color }}">{{ $tag }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Boarding --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-4">
                <div
                    class="inline-flex items-center gap-2 bg-gold/10 text-gold text-xs font-bold px-3 py-1.5 rounded-full mb-4">
                    🏠 Residential Facility</div>
            </div>
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden aspect-[4/3] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=800" alt="Boarding"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="absolute bottom-5 left-5 flex gap-3">
                        @foreach ([['Boys', 'Hostel Block A'], ['Girls', 'Hostel Block B'], ['24/7', 'Supervision']] as [$val, $label])
                            <div class="bg-navy text-white text-center rounded-xl px-3 py-2">
                                <div class="font-bold text-sm">{{ $val }}</div>
                                <div class="text-white/70 text-[10px]">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h2 class="font-display font-bold text-3xl text-navy mb-3">Boarding at SSSS</h2>
                    <div class="section-line mb-6"></div>
                    <p class="text-gray-600 mb-4 leading-relaxed">Our residential boarding facility provides a safe,
                        nurturing home-away-from-home for students who wish to immerse fully in the SSSS learning
                        environment.</p>
                    <h4 class="font-display font-bold text-navy mb-4">Why Choose SSSS Boarding?</h4>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed">Our boarding program is designed to provide a
                        structured, value-based residential experience. Students benefit from disciplined routines, peer
                        learning, and the constant guidance of dedicated housemaster staff.</p>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach ([['🛏️', 'Comfortable Dormitories', 'Spacious, well-ventilated rooms for 2–4 students with study desks and storage'], ['🍽️', 'Nutritious Meals', 'Freshly prepared vegetarian meals — breakfast, lunch, snack, and dinner'], ['📚', 'Study Facilities', 'Dedicated quiet study halls with supervised evening study hours'], ['🔒', '24/7 Supervision', 'Round-the-clock supervision by trained housemasters and resident staff'], ['🌿', 'Value-Based Living', 'Morning prayer, meditation, and evening satsang for spiritual growth'], ['⚽', 'Extra Activities', 'Weekend cultural events, recreational activities, and nature walks']] as [$icon, $title, $desc])
                            <div class="flex gap-3 items-start">
                                <span class="text-xl shrink-0">{{ $icon }}</span>
                                <div>
                                    <div class="text-sm font-semibold text-navy">{{ $title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $desc }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Daily Routine --}}
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Boarding Daily Routine</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="bg-gray-50 rounded-2xl p-8 grid sm:grid-cols-2 gap-8">
                <div>
                    <div class="text-red-500 font-semibold mb-4 flex items-center gap-2">⏰ Morning Routine</div>
                    @foreach ([['5:30 AM', 'Wake Up & Personal Care'], ['6:00 AM', 'Morning Prayer & Meditation'], ['6:30 AM', 'Yoga / Exercise'], ['7:30 AM', 'Breakfast'], ['8:00 AM', 'School Classes Begin']] as [$t, $a])
                        <div class="flex justify-between py-2.5 border-b border-gray-100">
                            <span class="text-navy font-bold text-sm">{{ $t }}</span>
                            <span class="text-gray-600 text-sm">{{ $a }}</span>
                        </div>
                    @endforeach
                </div>
                <div>
                    <div class="text-blue-600 font-semibold mb-4 flex items-center gap-2">🌙 Evening Routine</div>
                    @foreach ([['3:30 PM', 'School Ends / Sports & Activities'], ['5:30 PM', 'Evening Snack'], ['6:00 PM', 'Supervised Study Hour'], ['7:00 PM', 'Evening Satsaang / Prayer'], ['8:00 PM', 'Dinner & Lights Out (9:30 PM)']] as [$t, $a])
                        <div class="flex justify-between py-2.5 border-b border-gray-100">
                            <span class="text-navy font-bold text-sm">{{ $t }}</span>
                            <span class="text-gray-600 text-sm">{{ $a }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Campus Facilities --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Campus Facilities</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ([['Library', 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800', 'Well-stocked library with books across subjects and dedicated reading areas'], ['Sports Ground', 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800', 'Large playground for cricket, football, athletics, and other sports'], ['Cultural Hall', 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=800', 'Auditorium for assemblies, performances, and special events'], ['Cafeteria', 'https://images.unsplash.com/photo-1567521464027-f127ff144326?w=800', 'Clean dining facility serving nutritious and hygienic meals and snacks']] as [$name, $img, $desc])
                    <div class="rounded-2xl overflow-hidden shadow-sm bg-white">
                        <div class="relative aspect-video overflow-hidden">
                            <img src="{{ $img }}" alt="{{ $name }}" class="w-full h-full object-cover">
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="text-white font-bold text-lg">{{ $name }}</span>
                            </div>
                        </div>
                        <div class="p-5 text-sm text-gray-600">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Day Schedule --}}
    <section class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">A Day at SSSS</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="space-y-0">
                @foreach ([['7:45 AM – 8:00 AM', 'Morning Assembly & Prayer', '#f59e0b'], ['8:00 AM – 1:00 PM', 'Academic Classes (5–6 periods)', '#1a237e'], ['10:30 AM – 10:45 AM', 'Short Break & Refreshments', '#10b981'], ['1:00 PM – 1:45 PM', 'Lunch Break', '#e53e3e'], ['1:45 PM – 3:30 PM', 'Co-curricular Activities & Sports', '#8b5cf6']] as [$time, $activity, $color])
                    <div class="flex items-center justify-between py-4 border-b border-gray-100">
                        <span class="font-bold text-sm" style="color:{{ $color }}">{{ $time }}</span>
                        <span class="text-gray-600 text-sm text-right">{{ $activity }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Student Support --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Student Support Services</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ([['Academic Counseling', '#d97706', 'Personal guidance for students struggling with studies or needing extra support.'], ['Health Services', '#1a237e', 'First aid and basic medical care available during school hours.'], ['Career Guidance', '#10b981', 'Counseling for +2 students on career paths and higher education options.'], ['Transportation', '#e53e3e', 'School bus service available for students from various locations.'], ['Parent-Teacher Meetings', '#8b5cf6', 'Regular meetings to discuss student progress and development.'], ['Security', '#6b7280', 'Safe and secure campus environment with trained security personnel.']] as [$title, $color, $desc])
                    <div class="bg-white rounded-2xl p-6 border-l-4 shadow-sm" style="border-color:{{ $color }}">
                        <h4 class="font-display font-bold mb-2" style="color:{{ $color }}">{{ $title }}
                        </h4>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Annual Events --}}
    <section class="py-20 text-white text-center" style="background:linear-gradient(135deg,#1a237e,#4a148c,#b71c1c)">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="font-display font-bold text-4xl mb-3">Annual Events & Celebrations</h2>
            <p class="text-white/70 mb-12 text-sm max-w-2xl mx-auto">Throughout the year, we celebrate various festivals
                and organize special events that bring our entire school community together.</p>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ([['🎭', 'Annual Day', 'Cultural performances and prize distribution'], ['⚽', 'Sports Day', 'Inter-house athletic competitions'], ['🔬', 'Science Fair', 'Student projects and innovations showcase']] as [$icon, $title, $desc])
                    <div class="bg-white/10 border border-white/20 rounded-2xl p-6 backdrop-blur-sm">
                        <div class="text-3xl mb-3">{{ $icon }}</div>
                        <h4 class="font-display font-bold text-xl mb-2">{{ $title }}</h4>
                        <p class="text-white/70 text-sm">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-white text-center">
        <div class="max-w-2xl mx-auto px-4">
            <div class="text-4xl mb-4">🎓</div>
            <h2 class="font-display font-bold text-3xl text-navy mb-3">Ready to Be Part of SSSS?</h2>
            <p class="text-gray-500 mb-8">Join our vibrant community and experience education that nurtures the whole
                child.</p>
            <a href="{{ route('admissions.index') }}"
                class="inline-block btn-primary px-10 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all">Apply
                for Admission</a>
        </div>
    </section>

@endsection
