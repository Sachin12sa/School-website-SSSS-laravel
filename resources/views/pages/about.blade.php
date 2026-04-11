@extends('layouts.app')
@section('title', 'About Us — Sathya Sai Shiksha Sadan')
@section('content')

    {{-- ── Hero ──────────────────────────────────────────────────────────────── --}}
    <div class="relative py-28 text-center overflow-hidden"
        style="background: linear-gradient(135deg, rgba(26,35,126,0.88) 0%, rgba(183,28,28,0.7) 100%)">
        <div class="absolute inset-0 -z-10">
            <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1600"
                class="w-full h-full object-cover opacity-25" alt="">
        </div>
        <div class="max-w-3xl mx-auto px-4 text-white">
            <h1 class="font-display font-bold text-5xl mb-4">About Us</h1>
            <p class="text-white/80 text-lg leading-relaxed">
                Education in Human Values — Transforming Lives Since 2000
            </p>
        </div>
    </div>

    {{-- ── Our Mission ─────────────────────────────────────────────────────── --}}
    <section class="py-20 bg-white text-center">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="font-display font-bold text-3xl text-navy mb-3">Our Mission</h2>
            <div class="section-line mx-auto mb-8"></div>
            <p class="text-gray-600 leading-relaxed mb-6">
                Sathya Sai Shiksha Sadan is dedicated to providing quality education that nurtures not just academic
                excellence, but also character development through the five human values: Truth, Right Conduct, Peace, Love,
                and Non-Violence.
            </p>
            <p class="text-gray-600 leading-relaxed">
                We believe that education should develop the whole person — intellectually, emotionally, physically, and
                spiritually. Our students emerge as responsible citizens who contribute positively to society while
                maintaining
                strong moral and ethical foundations.
            </p>
        </div>
    </section>

    {{-- ── Five Human Values ───────────────────────────────────────────────── --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Five Human Values</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Truth (Sathya) --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow"
                    style="border-top: 3px solid #C9A227">
                    <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-navy text-lg mb-2">Truth (Sathya)</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        We cultivate honesty and integrity in all aspects of student life.
                    </p>
                </div>

                {{-- Right Conduct (Dharma) --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow"
                    style="border-top: 3px solid #C9A227">
                    <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-navy text-lg mb-2">Right Conduct (Dharma)</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        We instill moral and ethical behavior through example and practice.
                    </p>
                </div>

                {{-- Peace (Shanti) --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow"
                    style="border-top: 3px solid #C9A227">
                    <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-navy text-lg mb-2">Peace (Shanti)</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        We nurture inner harmony and peaceful coexistence among students.
                    </p>
                </div>

                {{-- Love & Non-Violence --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow"
                    style="border-top: 3px solid #C9A227">
                    <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-navy text-lg mb-2">Love & Non-Violence</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        We promote compassion, service, and respect for all life.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Our Journey ──────────────────────────────────────────────────────── --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-14 items-center">

            {{-- Text + Timeline --}}
            <div>
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Our Journey</h2>
                <div class="section-line mb-6"></div>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Since our establishment in 2000, Sathya Sai Shiksha Sadan has been committed to providing holistic
                    education that combines academic rigor with character development. What began as a small institution
                    has grown into a respected educational center serving hundreds of students from grades 1 through +2.
                </p>
                <div class="space-y-0">
                    @foreach ([['2000', 'Sathya Sai Shiksha Sadan established'], ['2005', 'Expanded to secondary level (up to grade 10)'], ['2010', 'Introduced +2 Science program'], ['2015', '+2 Management program launched'], ['2026', '26 years of excellence in education']] as [$year, $milestone])
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="font-bold text-sm" style="color:#e53e3e">{{ $year }}</span>
                            <span class="text-gray-600 text-sm text-right">{{ $milestone }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Image --}}
            <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[4/3]">
                <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800" alt="Our Journey"
                    class="w-full h-full object-cover">
            </div>

        </div>
    </section>

    {{-- ── Our Educational Philosophy ──────────────────────────────────────── --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Our Educational Philosophy</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6">

                @foreach ([['Educare', 'Drawing out the inherent goodness and potential within each child rather than just filling them with information.', '#1a237e'], ['Ceiling on Desires', 'Teaching students to live sustainably and responsibly, avoiding waste and excessive consumption.', '#1a237e'], ['Service to Society', 'Encouraging students to use their education for the betterment of society through selfless service.', '#1a237e']] as [$title, $desc, $color])
                    <div
                        class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="font-display font-bold mb-3" style="color:{{ $color }}">{{ $title }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ── Our Facilities ───────────────────────────────────────────────────── --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl text-navy mb-3">Our Facilities</h2>
                <div class="section-line mx-auto"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ([['Modern Classrooms', 'Well-ventilated, spacious classrooms equipped with modern teaching aids and comfortable seating arrangements.', '#e53e3e'], ['Science Laboratories', 'Fully equipped Physics, Chemistry, and Biology labs for hands-on practical learning and experiments.', '#e53e3e'], ['Library & Computer Lab', 'Well-stocked library with diverse books and a modern computer lab with internet connectivity.', '#e53e3e'], ['Sports Facilities', 'Playground for cricket, football, basketball, and facilities for indoor games and athletics.', '#e53e3e'], ['Meditation Hall', 'Dedicated space for prayer, meditation, and value education activities promoting inner peace.', '#e53e3e'], ['Cafeteria', 'Clean and hygienic cafeteria providing nutritious meals and snacks for students throughout the day.', '#e53e3e']] as [$name, $desc, $color])
                    <div
                        class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="font-display font-bold mb-2" style="color:{{ $color }}">{{ $name }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection
