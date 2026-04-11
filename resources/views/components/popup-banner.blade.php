{{--
    ═══════════════════════════════════════════════════════════
    DUAL-MODE POPUP BANNER
    
    Paste just before @stack('scripts') in layouts/app.blade.php:
        @include('components.popup-banner')
    
    MODE 1 — Image:   Admin uploads a PNG/JPG (from Canva/Figma)
    MODE 2 — Template: The designed template with text/fields
    MODE 3 — Both:    Image shown on top of the template area
    
    Controlled entirely from Admin → Settings → Popup Banner
    ═══════════════════════════════════════════════════════════
--}}

@php
    $forceShow = $forceShow ?? false;
    // Only enable if on the homepage ('/') OR if forceShow is true (for admin preview)
    $enabled = $forceShow || (\App\Models\SiteSetting::get('popup_enabled', '1') !== '0' && request()->is('/'));
    $mode = \App\Models\SiteSetting::get('popup_mode', 'template'); // 'image' | 'template' | 'image-top'
    $imageFile = \App\Models\SiteSetting::get('popup_image');
    $imageUrl =
        $imageFile && \Illuminate\Support\Facades\Storage::disk('public')->exists($imageFile)
            ? \Illuminate\Support\Facades\Storage::url($imageFile)
            : null;
    $imageLink = \App\Models\SiteSetting::get('popup_image_link', route('admissions.index'));
    $schoolName = \App\Models\SiteSetting::get('school_name', 'Sathya Sai Shiksha Sadan');
    $logoUrl = \App\Models\SiteSetting::logoUrl();

    // Template fields
    $badgeText = \App\Models\SiteSetting::get('popup_badge_text', 'Admissions Now Open');
    $subtitle = \App\Models\SiteSetting::get(
        'popup_subtitle',
        'Enrol now for the 2026–27 academic year. Limited seats available.',
    );
    $deadline = \App\Models\SiteSetting::get('popup_deadline', 'March 15, 2026 · Last date for submission');

    // Skip if disabled, or if image-mode but no image uploaded yet
    $show = $enabled && ($mode === 'template' || ($imageUrl && in_array($mode, ['image', 'image-top'])));
@endphp

@if ($show)
    <style>
        /* ── Overlay ───────────────────────────────────────────────────────────────── */
        #pbx {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(8, 13, 30, .85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            opacity: 0;
            animation: pbx-in .4s .55s ease forwards;
        }

        @keyframes pbx-in {
            to {
                opacity: 1
            }
        }

        /* ── Card ──────────────────────────────────────────────────────────────────── */
        #pbx-card {
            position: relative;
            width: 100%;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 36px 90px rgba(8, 13, 30, .4), 0 0 0 1px rgba(201, 162, 39, .12);
            transform: translateY(28px) scale(.97);
            opacity: 0;
            animation: pbx-card .52s .7s cubic-bezier(.22, 1, .36, 1) forwards;
        }

        /* Width varies by mode */
        #pbx-card.mode-image {
            max-width: 520px;
        }

        #pbx-card.mode-image-top {
            max-width: 520px;
        }

        #pbx-card.mode-template {
            max-width: 540px;
        }

        @keyframes pbx-card {
            to {
                transform: translateY(0) scale(1);
                opacity: 1
            }
        }

        /* ── Close btn ─────────────────────────────────────────────────────────────── */
        #pbx-close {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 20;
            width: 34px;
            height: 34px;
            background: rgba(0, 0, 0, .35);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, transform .2s;
            color: #fff;
        }

        #pbx-close:hover {
            background: rgba(0, 0, 0, .55);
            transform: scale(1.1);
        }

        #pbx-close svg {
            width: 15px;
            height: 15px;
        }

        /* ═══════════════════════════════════════════════════
   IMAGE MODE
═══════════════════════════════════════════════════ */
        .pbx-img-wrap {
            position: relative;
            display: block;
            line-height: 0;
        }

        .pbx-img-wrap img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 22px;
            cursor: {{ $imageLink ? 'pointer' : 'default' }};
        }

        /* Optional CTA bar below image */
        .pbx-img-cta {
            background: #fff;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            border-top: 1px solid #f0f0f0;
        }

        .pbx-img-cta-text {
            font-size: 12px;
            color: #64748b;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-btn-apply {
            background: linear-gradient(135deg, #C9A227, #dbb82f);
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 22px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            font-family: 'DM Sans', system-ui, sans-serif;
            box-shadow: 0 6px 18px rgba(201, 162, 39, .3);
            transition: transform .15s, box-shadow .15s;
            display: inline-block;
        }

        .pbx-btn-apply:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(201, 162, 39, .38);
        }

        /* ═══════════════════════════════════════════════════
   IMAGE-ON-TOP MODE (image + template below)
═══════════════════════════════════════════════════ */
        .pbx-img-top {
            display: block;
            line-height: 0;
        }

        .pbx-img-top img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 0;
            cursor: {{ $imageLink ? 'pointer' : 'default' }};
        }

        /* ═══════════════════════════════════════════════════
   TEMPLATE MODE — hero + body
═══════════════════════════════════════════════════ */
        .pbx-hero {
            position: relative;
            background: linear-gradient(135deg, #0d1628 0%, #1B2A4A 45%, #2d1f5e 100%);
            padding: 36px 32px 30px;
            overflow: hidden;
        }

        .pbx-hero::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 210px;
            height: 210px;
            border: 1.5px solid rgba(201, 162, 39, .15);
            border-radius: 50%;
            pointer-events: none;
        }

        .pbx-hero::after {
            content: '';
            position: absolute;
            top: -26px;
            right: -26px;
            width: 130px;
            height: 130px;
            border: 1.5px solid rgba(201, 162, 39, .08);
            border-radius: 50%;
            pointer-events: none;
        }

        .pbx-dots {
            position: absolute;
            bottom: 12px;
            left: -6px;
            width: 110px;
            height: 110px;
            background-image: radial-gradient(circle, rgba(201, 162, 39, .16) 1px, transparent 1px);
            background-size: 11px 11px;
            pointer-events: none;
        }

        .pbx-glow {
            position: absolute;
            bottom: -70px;
            right: -30px;
            width: 230px;
            height: 230px;
            background: radial-gradient(circle, rgba(201, 162, 39, .1) 0%, transparent 65%);
            pointer-events: none;
        }

        .pbx-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 50px;
            padding: 5px 13px 5px 5px;
            margin-bottom: 18px;
        }

        .pbx-chip-logo {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(201, 162, 39, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .pbx-chip-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .pbx-chip-initial {
            color: #C9A227;
            font-weight: 700;
            font-size: 13px;
            font-family: 'Playfair Display', Georgia, serif;
        }

        .pbx-chip-name {
            color: rgba(255, 255, 255, .75);
            font-size: 11px;
            font-weight: 600;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(201, 162, 39, .14);
            border: 1px solid rgba(201, 162, 39, .32);
            color: #C9A227;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .11em;
            text-transform: uppercase;
            padding: 4px 11px;
            border-radius: 50px;
            margin-bottom: 13px;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-badge-dot {
            width: 5px;
            height: 5px;
            background: #C9A227;
            border-radius: 50%;
            animation: pbx-blink 1.4s ease-in-out infinite;
        }

        @keyframes pbx-blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .25
            }
        }

        .pbx-heading {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.4rem, 4.5vw, 1.85rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.22;
            margin: 0 0 9px;
        }

        .pbx-heading .g {
            color: #C9A227;
        }

        .pbx-sub {
            color: rgba(255, 255, 255, .55);
            font-size: 12.5px;
            line-height: 1.65;
            margin: 0;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-body {
            padding: 24px 28px 28px;
            background: #fff;
        }

        .pbx-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 18px;
        }

        .pbx-pill {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #f4f6fb;
            border: 1px solid #e4e9f5;
            border-radius: 50px;
            padding: 5px 11px;
            font-size: 11px;
            font-weight: 600;
            color: #1B2A4A;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-deadline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            background: linear-gradient(135deg, #fdf8ec, #fef9ef);
            border: 1px solid rgba(201, 162, 39, .22);
            border-left: 4px solid #C9A227;
            border-radius: 11px;
            padding: 13px 15px;
            margin-bottom: 20px;
        }

        .pbx-dl-left {}

        .pbx-dl-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: #C9A227;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-dl-date {
            font-size: 12.5px;
            font-weight: 700;
            color: #1B2A4A;
            margin-top: 3px;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-dl-badge {
            background: #C9A227;
            color: #fff;
            font-size: 9.5px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 50px;
            font-family: 'DM Sans', system-ui, sans-serif;
            flex-shrink: 0;
        }

        .pbx-btns {
            display: flex;
            gap: 9px;
        }

        .pbx-btn-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: linear-gradient(135deg, #C9A227, #dbb82f);
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            padding: 13px 18px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', system-ui, sans-serif;
            box-shadow: 0 8px 22px rgba(201, 162, 39, .32);
            transition: transform .18s, box-shadow .18s;
        }

        .pbx-btn-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(201, 162, 39, .42);
        }

        .pbx-btn-main svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        .pbx-btn-sec {
            flex: 1;
            background: transparent;
            color: #1B2A4A;
            font-weight: 600;
            font-size: 13px;
            padding: 13px 18px;
            border-radius: 12px;
            text-decoration: none;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            font-family: 'DM Sans', system-ui, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color .18s, background .18s;
        }

        .pbx-btn-sec:hover {
            border-color: #1B2A4A;
            background: #f8f9fc;
        }

        .pbx-dismiss {
            text-align: center;
            margin-top: 16px;
            font-size: 11px;
            color: #94a3b8;
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .pbx-dismiss button {
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 11px;
            text-decoration: underline;
            font-family: 'DM Sans', system-ui, sans-serif;
            transition: color .15s;
        }

        .pbx-dismiss button:hover {
            color: #1B2A4A;
        }

        /* ── Stagger anims ─────────────────────────────────────────────────────────── */
        .pa {
            opacity: 0;
            transform: translateY(14px);
            animation: pa-in .45s ease forwards;
        }

        .pa:nth-child(1) {
            animation-delay: .85s
        }

        .pa:nth-child(2) {
            animation-delay: .95s
        }

        .pa:nth-child(3) {
            animation-delay: 1.05s
        }

        .pa:nth-child(4) {
            animation-delay: 1.15s
        }

        .pa:nth-child(5) {
            animation-delay: 1.25s
        }

        .pa:nth-child(6) {
            animation-delay: 1.35s
        }

        @keyframes pa-in {
            to {
                opacity: 1;
                transform: none
            }
        }

        /* ── Close animation ───────────────────────────────────────────────────────── */
        #pbx.closing {
            animation: pbx-out .28s ease forwards;
        }

        #pbx.closing #pbx-card {
            animation: pbx-card-out .28s ease forwards;
        }

        @keyframes pbx-out {
            to {
                opacity: 0
            }
        }

        @keyframes pbx-card-out {
            to {
                transform: translateY(14px) scale(.97);
                opacity: 0
            }
        }

        /* ── Mobile ────────────────────────────────────────────────────────────────── */
        @media(max-width:500px) {
            .pbx-hero {
                padding: 28px 22px 24px;
            }

            .pbx-body {
                padding: 20px 22px 24px;
            }

            #pbx-card {
                border-radius: 18px;
            }

            .pbx-heading {
                font-size: 1.35rem;
            }
        }
    </style>

    <div id="pbx" role="dialog" aria-modal="true" aria-label="Admissions announcement" style="display: none;">
        <div id="pbx-card" class="mode-{{ $mode }}">

            {{-- Close button --}}
            <button id="pbx-close" onclick="pbxClose()" aria-label="Close">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- ════════════════════════════════════════
         MODE: IMAGE ONLY
         Shows the uploaded PNG/JPG full-width.
         Clicking the image goes to $imageLink.
    ════════════════════════════════════════ --}}
            @if ($mode === 'image' && $imageUrl)
                <div class="pbx-img-wrap">
                    @if ($imageLink)
                        <a href="{{ $imageLink }}" onclick="pbxClose()">
                            <img src="{{ $imageUrl }}" alt="School announcement banner">
                        </a>
                    @else
                        <img src="{{ $imageUrl }}" alt="School announcement banner">
                    @endif
                </div>
                {{-- Optional apply CTA strip below image --}}
                <div class="pbx-img-cta">
                    <span class="pbx-img-cta-text">Questions? <a href="{{ route('contact.index') }}"
                            onclick="pbxClose()" style="color:#C9A227;font-weight:600">Contact us →</a></span>
                    <a href="{{ route('admissions.index') }}" onclick="pbxClose()" class="pbx-btn-apply">Apply Now</a>
                </div>

                {{-- ════════════════════════════════════════
         MODE: IMAGE ON TOP + TEMPLATE BELOW
         Best for: custom banner with more detail
    ════════════════════════════════════════ --}}
            @elseif($mode === 'image-top' && $imageUrl)
                {{-- Image section --}}
                <div class="pbx-img-top">
                    @if ($imageLink)
                        <a href="{{ $imageLink }}" onclick="pbxClose()">
                            <img src="{{ $imageUrl }}" alt="School announcement banner">
                        </a>
                    @else
                        <img src="{{ $imageUrl }}" alt="School announcement banner">
                    @endif
                </div>
                {{-- Template section below image --}}
                <div class="pbx-body">
                    <div class="pbx-deadline pa">
                        <div class="pbx-dl-left">
                            <div class="pbx-dl-label">Application Deadline</div>
                            <div class="pbx-dl-date">{{ $deadline }}</div>
                        </div>
                        <span class="pbx-dl-badge">Limited Seats</span>
                    </div>
                    <div class="pbx-btns pa">
                        <a href="{{ route('admissions.index') }}" class="pbx-btn-main" onclick="pbxClose()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Apply for Admission
                        </a>
                        <a href="{{ route('contact.index') }}" class="pbx-btn-sec" onclick="pbxClose()">Ask a
                            Question</a>
                    </div>
                    <div class="pbx-dismiss pa">
                        <button onclick="pbxClose()">Continue to website ↓</button>
                    </div>
                </div>

                {{-- ════════════════════════════════════════
         MODE: TEMPLATE ONLY
         The designed template with all fields.
    ════════════════════════════════════════ --}}
            @else
                {{-- Hero --}}
                <div class="pbx-hero">
                    <div class="pbx-dots"></div>
                    <div class="pbx-glow"></div>
                    {{-- School chip --}}
                    <div class="pbx-chip pa">
                        <div class="pbx-chip-logo">
                            @if ($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $schoolName }}">
                            @else
                                <span class="pbx-chip-initial">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                            @endif
                        </div>
                        <span class="pbx-chip-name">{{ $schoolName }}</span>
                    </div>
                    {{-- Badge --}}
                    <div class="pa">
                        <div class="pbx-badge">
                            <span class="pbx-badge-dot"></span>
                            {{ $badgeText }}
                        </div>
                    </div>
                    {{-- Heading --}}
                    <h2 class="pbx-heading pa">
                        Give Your Child<br>the Gift of <span class="g">Human Values</span>
                    </h2>
                    <p class="pbx-sub pa">{{ $subtitle }}</p>
                </div>
                {{-- Body --}}
                <div class="pbx-body">
                    <div class="pbx-pills pa">
                        @foreach (['🎓 Grade 1 to +2', '👨‍🏫 Expert Faculty', '🏠 Boarding', '🌟 Human Values', '🏆 100% Results'] as $pill)
                            <span class="pbx-pill">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <div class="pbx-deadline pa">
                        <div class="pbx-dl-left">
                            <div class="pbx-dl-label">Application Deadline</div>
                            <div class="pbx-dl-date">{{ $deadline }}</div>
                        </div>
                        <span class="pbx-dl-badge">Apply Now</span>
                    </div>
                    <div class="pbx-btns pa">
                        <a href="{{ route('admissions.index') }}" class="pbx-btn-main" onclick="pbxClose()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Apply for Admission
                        </a>
                        <a href="{{ route('contact.index') }}" class="pbx-btn-sec" onclick="pbxClose()">Learn More</a>
                    </div>
                    <div class="pbx-dismiss pa">
                        <button onclick="pbxClose()">Continue to website ↓</button>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        (function() {
            var o = document.getElementById('pbx');
            // Ensure display is block or flex before animation starts running
            o.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            o.addEventListener('click', function(e) {
                if (e.target === o) pbxClose();
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') pbxClose();
            });
        })();
        window.pbxClose = function() {
            var o = document.getElementById('pbx');

            o.classList.add('closing');
            setTimeout(function() {
                o.style.display = 'none';
                document.body.style.overflow = '';
            }, 290);
        };
        // Option for admin live preview to force show
        window.pbxForceShow = function() {
            var o = document.getElementById('pbx');
            o.classList.remove('closing');
            o.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
    </script>
@endif
