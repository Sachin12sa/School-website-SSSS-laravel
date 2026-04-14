@extends('layouts.app')
@section('title', 'School Calendar')
@section('meta_description', 'View upcoming events, news, gallery and school activities for ' .
    \App\Models\SiteSetting::get('school_name', 'Our School') . '.')

    @push('styles')
        <style>
            /* ── Calendar grid ─────────────────────────────────────────────────────────── */
            .cal-grid {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 0;
            }

            .cal-day {
                min-height: 80px;
                padding: 8px 6px 6px;
                border-right: 1px solid #f1f5f9;
                border-bottom: 1px solid #f1f5f9;
                cursor: pointer;
                transition: background .18s ease;
                position: relative;
            }

            .cal-day:hover {
                background: #f8faff;
            }

            .cal-day.today {
                background: #1B2A4A !important;
                border-radius: 0;
            }

            .cal-day.today .day-num {
                color: #fff;
            }

            .cal-day.selected {
                background: #f0f5ff;
            }

            .cal-day.selected .day-num {
                color: #1B2A4A;
                font-weight: 700;
            }

            .cal-day.other-month {
                background: #fafafa;
            }

            .cal-day.other-month .day-num {
                color: #cbd5e1;
            }

            /* Day number */
            .day-num {
                font-size: 13px;
                font-weight: 500;
                color: #1e293b;
                line-height: 1;
                display: block;
            }

            .day-num.sunday {
                color: #E53E3E;
            }

            .day-num.saturday {
                color: #E53E3E;
            }

            /* Today circle */
            .today .day-num {
                width: 28px;
                height: 28px;
                background: #fff;
                color: #1B2A4A !important;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 13px;
                margin: 0 auto 2px;
            }

            /* Event dots */
            .dots-row {
                display: flex;
                flex-wrap: wrap;
                gap: 2px;
                margin-top: 4px;
                justify-content: center;
            }

            .dot {
                width: 5px;
                height: 5px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            /* ── Header weekdays ───────────────────────────────────────────────────────── */
            .cal-header-cell {
                text-align: center;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: .05em;
                text-transform: uppercase;
                color: #94a3b8;
                padding: 10px 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .cal-header-cell.sun,
            .cal-header-cell.sat {
                color: #f87171;
            }

            /* ── Sidebar upcoming item ─────────────────────────────────────────────────── */
            .up-item {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                padding: 10px 0;
                border-bottom: 1px solid #f8f9fb;
                cursor: pointer;
                transition: background .15s;
                border-radius: 8px;
                padding: 8px;
                margin: 0 -8px;
            }

            .up-item:hover {
                background: #f8faff;
            }

            .up-item:last-child {
                border-bottom: none;
            }

            .up-icon {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .up-title {
                font-size: 12px;
                font-weight: 600;
                color: #1e293b;
                line-height: 1.3;
                margin-bottom: 2px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 130px;
            }

            .up-date {
                font-size: 10px;
                color: #94a3b8;
            }

            .type-badge {
                font-size: 9px;
                font-weight: 700;
                padding: 2px 7px;
                border-radius: 50px;
                flex-shrink: 0;
                margin-left: auto;
                align-self: flex-start;
                margin-top: 2px;
            }

            /* ── Day detail panel ──────────────────────────────────────────────────────── */
            .detail-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                transition: box-shadow .2s;
            }

            .detail-card:hover {
                box-shadow: 0 8px 24px rgba(27, 42, 74, .08);
            }

            /* ── Summary stat ──────────────────────────────────────────────────────────── */
            .stat-pill {
                display: flex;
                align-items: center;
                gap: 10px;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 12px 16px;
            }

            .stat-num {
                font-size: 20px;
                font-weight: 700;
                color: #1B2A4A;
                line-height: 1;
            }

            .stat-label {
                font-size: 11px;
                color: #94a3b8;
                margin-top: 2px;
            }

            /* ── Loading spinner ───────────────────────────────────────────────────────── */
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .spinner {
                animation: spin .8s linear infinite;
            }

            /* Mobile */
            @media(max-width:768px) {
                .cal-day {
                    min-height: 52px;
                    padding: 5px 3px 3px;
                }

                .day-num {
                    font-size: 11px;
                }

                .dot {
                    width: 4px;
                    height: 4px;
                }
            }
        </style>
    @endpush

@section('content')

    @php
        $monthName = $date->format('F Y');
        $daysInMonth = $date->daysInMonth;
        $firstDow = $date->copy()->startOfMonth()->dayOfWeek; // 0=Sun
        $today = \Carbon\Carbon::today();
        $isCurrentMonth = $date->month === $today->month && $date->year === $today->year;
    @endphp

    {{-- ══════════════════════════════════════════════════
     HERO BAR
══════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden"
        style="background:linear-gradient(135deg,#1B2A4A 0%,#16223d 60%,#2d1f5e 100%); min-height:160px">
        {{-- Decorative circles --}}
        <div class="absolute top-4 right-12 w-32 h-32 rounded-full border border-white/6 hidden md:block"></div>
        <div class="absolute top-10 right-28 w-20 h-20 rounded-full border border-white/5 hidden md:block"></div>
        <div class="absolute bottom-2 right-4 w-48 h-48 rounded-full border border-white/4 hidden md:block"></div>
        <div class="absolute -top-6 left-1/3 w-24 h-24 rounded-full bg-white/2 hidden md:block"></div>

        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-10 relative">
            <div class="flex items-start gap-4 mb-6">
                <div
                    class="w-12 h-12 bg-white/10 border border-white/15 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-display font-bold text-white text-3xl lg:text-4xl leading-tight">School Calendar</h1>
                    <p class="text-white/55 text-sm mt-1">Events, News & Gallery — All in one place</p>
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex flex-wrap gap-3">
                @foreach ([['#378ADD', 'Event', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'], ['#E53E3E', 'News', 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'], ['#9F7AEA', 'Gallery', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z']] as [$color, $label, $path])
                    <div class="flex items-center gap-2 bg-white/10 border border-white/10 rounded-full px-3.5 py-1.5">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background:{{ $color }}"></span>
                        <span class="text-white text-xs font-semibold">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════════ --}}
    <div class="bg-slate-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="grid lg:grid-cols-[1fr_280px] gap-6">

                {{-- ══════════════════════════════════════════
             LEFT: Calendar + Stats + Day Detail
        ══════════════════════════════════════════ --}}
                <div class="space-y-5">

                    {{-- ── Calendar Card ──────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                        {{-- Month nav --}}
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                            <a href="{{ route('calendar.index', ['year' => $prevDate->year, 'month' => $prevDate->month]) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 hover:text-navy-900 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <div class="text-center">
                                <h2 class="font-display font-bold text-navy-900 text-lg">{{ $monthName }}</h2>
                                <p class="text-slate-400 text-xs mt-0.5">Click any date to view items</p>
                            </div>
                            <a href="{{ route('calendar.index', ['year' => $nextDate->year, 'month' => $nextDate->month]) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 hover:text-navy-900 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        {{-- Weekday headers --}}
                        <div class="cal-grid">
                            @foreach (['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'] as $i => $day)
                                <div class="cal-header-cell {{ in_array($i, [0, 6]) ? ($i === 0 ? 'sun' : 'sat') : '' }}">
                                    {{ $day }}</div>
                            @endforeach
                        </div>

                        {{-- Calendar days grid --}}
                        <div class="cal-grid" id="cal-grid">

                            {{-- Leading empty cells --}}
                            @for ($e = 0; $e < $firstDow; $e++)
                                @php
                                    $d = $date
                                        ->copy()
                                        ->startOfMonth()
                                        ->subDays($firstDow - $e);
                                @endphp
                                <div class="cal-day other-month" data-date="{{ $d->format('Y-m-d') }}"
                                    onclick="selectDay(this)">
                                    <span class="day-num">{{ $d->day }}</span>
                                </div>
                            @endfor

                            {{-- Days of this month --}}
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $currentDate = $date->copy()->setDay($day);
                                    $isToday = $isCurrentMonth && $day === $today->day;
                                    $dow = $currentDate->dayOfWeek;
                                    $dots = $dayMap[(string) $day] ?? [];
                                    $dateStr = $currentDate->format('Y-m-d');
                                @endphp
                                <div class="cal-day {{ $isToday ? 'today' : '' }}" data-date="{{ $dateStr }}"
                                    onclick="selectDay(this)" id="day-{{ $dateStr }}">
                                    {{-- Day number --}}
                                    @if ($isToday)
                                        <div class="flex justify-center mb-1">
                                            <span class="day-num">{{ $day }}</span>
                                        </div>
                                    @else
                                        <span
                                            class="day-num {{ $dow === 0 || $dow === 6 ? 'saturday' : '' }} block text-center">{{ $day }}</span>
                                    @endif

                                    {{-- Dots --}}
                                    @if (count($dots) > 0)
                                        <div class="dots-row">
                                            @foreach (array_slice($dots, 0, 4) as $dot)
                                                <span class="dot" style="background:{{ $dot['color'] }}"></span>
                                            @endforeach
                                            @if (count($dots) > 4)
                                                <span
                                                    style="font-size:8px;color:#94a3b8;line-height:5px">+{{ count($dots) - 4 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endfor

                            {{-- Trailing empty cells --}}
                            @php
                                $lastDow = $date->copy()->endOfMonth()->dayOfWeek;
                                $trailingCells = $lastDow < 6 ? 6 - $lastDow : 0;
                            @endphp
                            @for ($t = 1; $t <= $trailingCells; $t++)
                                @php $d = $date->copy()->endOfMonth()->addDays($t); @endphp
                                <div class="cal-day other-month" data-date="{{ $d->format('Y-m-d') }}"
                                    onclick="selectDay(this)">
                                    <span class="day-num">{{ $d->day }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- ── Monthly Summary Stats ─────────────────────────────── --}}
                    <div class="grid grid-cols-3 gap-3">
                        @foreach ([['#378ADD', 'rgba(55,138,221,.1)', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', $summary['events'], 'Events'], ['#E53E3E', 'rgba(229,62,62,.1)', 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', $summary['news'], 'News'], ['#9F7AEA', 'rgba(159,122,234,.1)', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', $summary['galleries'], 'Galleries']] as [$color, $bg, $path, $count, $label])
                            <div class="stat-pill">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                                    style="background:{{ $bg }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="color:{{ $color }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $path }}" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="stat-num">{{ $count }}</div>
                                    <div class="stat-label">{{ $label }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- ── Day Detail Panel (shown on date click) ────────────── --}}
                    <div id="day-detail" class="hidden">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-display font-bold text-navy-900 text-lg">
                                    Items on <span id="detail-date" class="text-gold"></span>
                                </h3>
                                <p id="detail-count" class="text-slate-400 text-xs mt-0.5"></p>
                            </div>
                            {{-- Filter tabs --}}
                            <div class="flex gap-1.5" id="detail-tabs">
                                <button onclick="filterItems('all')" data-tab="all"
                                    class="tab-btn active text-xs font-bold px-3 py-1.5 rounded-lg transition-colors bg-navy-900 text-white">
                                    All
                                </button>
                                <button onclick="filterItems('event')" data-tab="event"
                                    class="tab-btn text-xs font-bold px-3 py-1.5 rounded-lg transition-colors bg-slate-100 text-slate-500 hover:bg-slate-200">
                                    Events
                                </button>
                                <button onclick="filterItems('news')" data-tab="news"
                                    class="tab-btn text-xs font-bold px-3 py-1.5 rounded-lg transition-colors bg-slate-100 text-slate-500 hover:bg-slate-200">
                                    News
                                </button>
                                <button onclick="filterItems('gallery')" data-tab="gallery"
                                    class="tab-btn text-xs font-bold px-3 py-1.5 rounded-lg transition-colors bg-slate-100 text-slate-500 hover:bg-slate-200">
                                    Gallery
                                </button>
                            </div>
                        </div>

                        {{-- Loading state --}}
                        <div id="detail-loading" class="hidden text-center py-12">
                            <svg class="spinner w-8 h-8 text-navy-900 mx-auto" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <p class="text-slate-400 text-sm mt-2">Loading…</p>
                        </div>

                        {{-- Items grid --}}
                        <div id="detail-grid" class="grid sm:grid-cols-2 gap-4"></div>

                        {{-- Empty state --}}
                        <div id="detail-empty"
                            class="hidden text-center py-14 bg-white rounded-2xl border border-slate-100">
                            <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-slate-400 text-sm font-medium">Nothing on this date</p>
                            <p class="text-slate-300 text-xs mt-1">Try clicking another date</p>
                        </div>
                    </div>

                </div>

                {{-- ══════════════════════════════════════════
             RIGHT: Upcoming Events Sidebar
        ══════════════════════════════════════════ --}}
                <div class="space-y-5">

                    {{-- Upcoming events card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                        <h3 class="font-display font-bold text-navy-900 text-base mb-1">Upcoming Events</h3>
                        <p class="text-slate-400 text-xs mb-4">{{ $date->format('F Y') }}</p>

                        @forelse($upcoming as $event)
                            @php
                                $typeColors = [
                                    'Event' => [
                                        'bg' => '#EBF5FB',
                                        'color' => '#378ADD',
                                        'badge' => '#dbeafe',
                                        'badgeText' => '#1e40af',
                                    ],
                                    'Holiday' => [
                                        'bg' => '#F0FFF4',
                                        'color' => '#38A169',
                                        'badge' => '#dcfce7',
                                        'badgeText' => '#166534',
                                    ],
                                    'Exam' => [
                                        'bg' => '#FFF5F5',
                                        'color' => '#E53E3E',
                                        'badge' => '#fee2e2',
                                        'badgeText' => '#991b1b',
                                    ],
                                    'Notice' => [
                                        'bg' => '#FFFFF0',
                                        'color' => '#D69E2E',
                                        'badge' => '#fef9c3',
                                        'badgeText' => '#854d0e',
                                    ],
                                ];
                                $tc = $typeColors[$event->category ?? 'Event'] ?? $typeColors['Event'];
                            @endphp
                            <div class="up-item" onclick="loadDay('{{ $event->start_date->format('Y-m-d') }}')">
                                <div class="up-icon" style="background:{{ $tc['bg'] }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="color:{{ $tc['color'] }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="up-title">{{ Str::limit($event->title, 22) }}</div>
                                    <div class="up-date">{{ $event->start_date->format('M j, Y') }}</div>
                                </div>
                                <span class="type-badge"
                                    style="background:{{ $tc['badge'] }};color:{{ $tc['badgeText'] }}">
                                    {{ $event->category ?? 'Event' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-300">
                                <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs text-slate-400">No upcoming events</p>
                            </div>
                        @endforelse

                        @if ($upcoming->count())
                            <a href="{{ route('events.index') }}"
                                class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 border border-slate-200 hover:border-navy-900 text-slate-500 hover:text-navy-900 text-xs font-semibold rounded-xl transition-colors">
                                View All Events
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    {{-- Quick jump to today --}}
                    @if (!$isCurrentMonth)
                        <a href="{{ route('calendar.index') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 bg-navy-900 hover:bg-gold text-white text-sm font-bold rounded-2xl transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Back to Today
                        </a>
                    @endif

                    {{-- Mini legend card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                        <h4 class="font-semibold text-navy-900 text-sm mb-3">Legend</h4>
                        <div class="space-y-2">
                            @foreach ([['#378ADD', 'Events', 'School events and programmes'], ['#E53E3E', 'News', 'Published news & announcements'], ['#9F7AEA', 'Gallery', 'Photo albums from school activities']] as [$color, $label, $desc])
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full shrink-0"
                                        style="background:{{ $color }}"></span>
                                    <div>
                                        <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>
                                        <span class="text-slate-400 text-xs ml-1">— {{ $desc }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ─── State ────────────────────────────────────────────────────────────────────
        let allItems = [];
        let activeDate = null;
        const AJAX_URL = '{{ route('calendar.day') }}';

        // ─── Type config ─────────────────────────────────────────────────────────────
        const typeConfig = {
            event: {
                color: '#378ADD',
                bg: '#EBF5FB',
                badgeBg: '#dbeafe',
                badgeColor: '#1e40af',
                label: 'Event',
                icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                btn: 'Read More',
            },
            news: {
                color: '#E53E3E',
                bg: '#FFF5F5',
                badgeBg: '#fee2e2',
                badgeColor: '#991b1b',
                label: 'News',
                icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                btn: 'Read Article',
            },
            gallery: {
                color: '#9F7AEA',
                bg: '#FAF5FF',
                badgeBg: '#ede9fe',
                badgeColor: '#5b21b6',
                label: 'Gallery',
                icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                btn: 'View Gallery',
            },
        };

        // ─── Select a day (click on calendar cell) ────────────────────────────────────
        function selectDay(el) {
            const date = el.dataset.date;

            // Highlight selected
            document.querySelectorAll('.cal-day').forEach(d => {
                if (!d.classList.contains('today')) d.classList.remove('selected');
            });
            if (!el.classList.contains('today')) el.classList.add('selected');

            loadDay(date);
        }

        // ─── Load items for a date (AJAX) ─────────────────────────────────────────────
        function loadDay(date) {
            activeDate = date;

            const detail = document.getElementById('day-detail');
            const loading = document.getElementById('detail-loading');
            const grid = document.getElementById('detail-grid');
            const empty = document.getElementById('detail-empty');
            const dateEl = document.getElementById('detail-date');
            const countEl = document.getElementById('detail-count');

            // Show panel
            detail.classList.remove('hidden');
            loading.classList.remove('hidden');
            grid.classList.add('hidden');
            empty.classList.add('hidden');
            grid.innerHTML = '';

            // Scroll to detail panel
            setTimeout(() => detail.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            }), 50);

            // Fetch
            fetch(`${AJAX_URL}?date=${date}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    loading.classList.add('hidden');
                    allItems = data.items;

                    dateEl.textContent = data.date;
                    countEl.textContent = data.count + ' item' + (data.count !== 1 ? 's' : '') + ' found';

                    if (data.count === 0) {
                        empty.classList.remove('hidden');
                    } else {
                        grid.classList.remove('hidden');
                        renderItems(data.items);
                    }

                    // Reset filter tabs
                    document.querySelectorAll('.tab-btn').forEach(b => {
                        b.classList.remove('bg-navy-900', 'text-white');
                        b.classList.add('bg-slate-100', 'text-slate-500');
                    });
                    document.querySelector('[data-tab="all"]').classList.add('bg-navy-900', 'text-white');
                    document.querySelector('[data-tab="all"]').classList.remove('bg-slate-100', 'text-slate-500');
                })
                .catch(() => {
                    loading.classList.add('hidden');
                    empty.classList.remove('hidden');
                });
        }

        // ─── Render item cards ────────────────────────────────────────────────────────
        function renderItems(items) {
            const grid = document.getElementById('detail-grid');
            grid.innerHTML = '';

            if (!items.length) {
                grid.classList.add('hidden');
                document.getElementById('detail-empty').classList.remove('hidden');
                return;
            }

            document.getElementById('detail-empty').classList.add('hidden');
            grid.classList.remove('hidden');

            items.forEach(item => {
                const tc = typeConfig[item.type] || typeConfig.event;
                const hasImage = item.image && item.image !== '' && !item.image.includes('placehold.co/800x450');

                const card = document.createElement('div');
                card.className = 'detail-card';
                card.dataset.type = item.type;

                card.innerHTML = `
            ${hasImage ? `
                <div style="aspect-ratio:16/7;overflow:hidden;position:relative">
                    <img src="${item.image}" alt="${item.title}"
                         style="width:100%;height:100%;object-fit:cover">
                    <span style="position:absolute;top:10px;left:10px;background:${tc.color};color:#fff;
                                 font-size:10px;font-weight:700;padding:3px 10px;border-radius:50px">
                        ${tc.label}
                    </span>
                    ${item.category && item.category !== tc.label ? `
                <span style="position:absolute;top:10px;right:10px;background:rgba(255,255,255,.9);
                             color:#374151;font-size:10px;font-weight:700;padding:3px 10px;border-radius:50px">
                    ${item.category}
                </span>` : ''}
                </div>` : ''}

            <div style="padding:16px">
                ${!hasImage ? `<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                        <div style="width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:${tc.bg}">
                            <svg style="width:14px;height:14px;color:${tc.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${tc.icon}"/>
                            </svg>
                        </div>
                        <span style="background:${tc.badgeBg};color:${tc.badgeColor};font-size:10px;font-weight:700;
                                     padding:2px 8px;border-radius:50px">${tc.label}</span>
                        ${item.category && item.category !== tc.label ? `<span style="color:#94a3b8;font-size:10px">${item.category}</span>` : ''}
                    </div>` : ''}

                <h4 style="font-weight:700;font-size:14px;color:#1e293b;margin:0 0 6px;line-height:1.4">
                    ${item.title}
                </h4>

                ${item.desc ? `<p style="font-size:12px;color:#64748b;margin:0 0 12px;line-height:1.6;
                                             display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                        ${item.desc}
                    </p>` : ''}

                ${item.location ? `<p style="font-size:11px;color:#94a3b8;margin:0 0 10px;display:flex;align-items:center;gap:4px">
                        <svg style="width:12px;height:12px" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        ${item.location}
                    </p>` : ''}

                <a href="${item.url}"
                   style="display:inline-flex;align-items:center;gap:6px;
                          border:1.5px solid ${tc.color};color:${tc.color};
                          font-size:12px;font-weight:700;padding:7px 14px;
                          border-radius:10px;text-decoration:none;transition:all .18s"
                   onmouseover="this.style.background='${tc.color}';this.style.color='#fff'"
                   onmouseout="this.style.background='transparent';this.style.color='${tc.color}'">
                    ${item.type === 'gallery' ? `
                        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>` : `
                        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>`}
                    ${tc.btn}
                </a>
            </div>
        `;
                grid.appendChild(card);
            });
        }

        // ─── Filter items by type ─────────────────────────────────────────────────────
        function filterItems(type) {
            // Update tabs
            document.querySelectorAll('.tab-btn').forEach(b => {
                const active = b.dataset.tab === type;
                b.classList.toggle('bg-navy-900', active);
                b.classList.toggle('text-white', active);
                b.classList.toggle('bg-slate-100', !active);
                b.classList.toggle('text-slate-500', !active);
            });

            const filtered = type === 'all' ? allItems : allItems.filter(i => i.type === type);
            renderItems(filtered);
        }

        // ─── Auto-load today if in current month ─────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            @if ($isCurrentMonth)
                const todayEl = document.querySelector('.cal-day.today');
                if (todayEl) {
                    setTimeout(() => selectDay(todayEl), 400);
                }
            @endif
        });
    </script>
@endpush
