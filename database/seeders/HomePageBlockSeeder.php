<?php

namespace Database\Seeders;

use App\Models\PageBlock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class HomePageBlockSeeder extends Seeder
{
    /**
     * Seed all homepage blocks in the exact order they appear on the front end.
     *
     * Run:  php artisan db:seed --class=PageBlockSeeder
     * Reset: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // Wipe existing global (homepage) blocks so re-seeding is idempotent
        PageBlock::whereNull('page_id')->delete();

        $blocks = [

            
            

            // ── 2. STATS ────────────────────────────────────────────────────
            [
                'type'        => 'stats',
                'title'       => 'Our Numbers',
                'subtitle'    => null,
                'content'     => null,
                'button_text' => null,
                'button_url'  => null,
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 1,
                'extra'       => [
                    'students' => '500+',
                    'teachers' => '40+',
                    'years' => '26',
                    'programmes' => '3',
                ],
            ],
           
            // ── 3. ABOUT INTRO ────────────────────────────────────────────────
            [
                'type'        => 'about_intro',
                'title'       => 'About Sathya Sai Shiksha Sadan',
                'subtitle'    => null,
                'content'     => '<p>At Sathya Sai Shiksha Sadan, we believe that education extends beyond textbooks. Our mission is to nurture young minds with a perfect blend of academic excellence and human values, creating responsible citizens and future leaders.</p><br><p>From primary education through higher secondary (+2) levels, we provide a supportive environment where students develop intellectually, emotionally, and morally. Our dedicated faculty ensures every student receives personalized attention and guidance.</p>',
                'button_text' => 'Our Story',
                'button_url'  => '/about',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 2,
                'extra'       => [
                    'background' => '#fff',
                    'accent' => 'var(--gold)',
                    'cards' => [
                        ['title' => 'Primary Level', 'badge' => 'Grades 1-5', 'description' => 'Building strong foundations in core subjects with focus on holistic development.', 'color' => 'var(--gold)', 'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=700', 'url' => '/programs#primary'],
                        ['title' => 'Secondary Level', 'badge' => 'Grades 6-10', 'description' => 'Comprehensive education preparing students for higher secondary and beyond.', 'color' => 'var(--navy)', 'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=700', 'url' => '/programs#secondary'],
                        ['title' => '+2 Science & Mgmt', 'badge' => 'Grades 11-12', 'description' => 'Specialised streams in Science and Management for confident future pathways.', 'color' => 'var(--gold-dark)', 'image' => 'https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=700', 'url' => '/programs#science'],
                    ],
                ],
            ],

            // ── 4. PROGRAMS ───────────────────────────────────────────────────
            [
                'type'        => 'programs',
                'title'       => 'Our Academic Programs',
                'subtitle'    => 'Comprehensive education from foundation to specialisation, designed to unlock every student\'s potential.',
                'content'     => null,
                'button_text' => null,
                'button_url'  => '/programs',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 3,
                'extra'       => [
                    'background' => 'var(--cream)',
                    'accent' => 'var(--gold)',
                    'items' => [
                        ['number' => '1', 'title' => 'Truth (Sathya)', 'description' => 'Honesty and integrity in thought, word, and deed'],
                        ['number' => '2', 'title' => 'Right Conduct (Dharma)', 'description' => 'Moral and ethical behavior in all situations'],
                        ['number' => '3', 'title' => 'Peace (Shanti)', 'description' => 'Inner harmony and calm disposition'],
                        ['number' => '4', 'title' => 'Love (Prema)', 'description' => 'Compassion and selfless service to others'],
                        ['number' => '5', 'title' => 'Non-Violence (Ahimsa)', 'description' => 'Respect for all life and peaceful coexistence'],
                    ],
                ],
            ],

            // ── 5. FIVE HUMAN VALUES ──────────────────────────────────────────
            [
                'type'        => 'values',
                'title'       => 'Five Human Values',
                'subtitle'    => 'Our educational philosophy is built on five pillars that shape character and guide every student\'s growth.',
                'content'     => null,
                'button_text' => null,
                'button_url'  => null,
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 4,
                'extra'       => [
                    'background' => '#fff',
                    'card_bg' => 'var(--cream)',
                ],
            ],

            // ── 6. LEGACY / HISTORY TIMELINE ─────────────────────────────────
            [
                'type'        => 'legacy',
                'title'       => 'A Legacy of Excellence',
                'subtitle'    => null,
                'content'     => 'Since our founding in 2000, Sathya Sai Shiksha Sadan has been a beacon of value-based education. What began as a small institution with a big vision has grown into a comprehensive school serving hundreds of students from Grade 1 to +2.',
                'button_text' => null,
                'button_url'  => null,
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 5,
                'extra'       => [
                    'timeline' => [
                        ['year' => '2000', 'text' => 'Sathya Sai Shiksha Sadan established with a vision of value-based education'],
                        ['year' => '2005', 'text' => 'Expanded to secondary level — welcoming students up to Grade 10'],
                        ['year' => '2010', 'text' => '+2 Science stream introduced for Grades 11 & 12'],
                        ['year' => '2015', 'text' => '+2 Management stream launched to serve aspiring business leaders'],
                        ['year' => '2026', 'text' => '26 proud years of nurturing excellence and human values'],
                    ],
                ],
            ],

            // ── 7. NEWS FEED ──────────────────────────────────────────────────
            [
                'type'        => 'news_feed',
                'title'       => 'Latest News & Updates',
                'subtitle'    => 'Stay Informed',
                'content'     => null,
                'button_text' => 'View All',
                'button_url'  => '/news',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 6,
                'extra'       => [
                    'background' => '#111a30',
                    'secondary_button_text' => 'Learn More',
                    'secondary_button_url' => '/contact',
                    'particle_1' => 'rgba(255,255,255,0.1)',
                    'particle_2' => 'rgba(201,162,39,0.4)',
                ],
            ],

            // ── 8. EVENTS FEED ────────────────────────────────────────────────
            [
                'type'        => 'events_feed',
                'title'       => 'Upcoming Events',
                'subtitle'    => null,
                'content'     => null,
                'button_text' => 'View All Events',
                'button_url'  => '/events',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 7,
                'extra'       => null,
            ],

            // ── 9. GALLERY PREVIEW ────────────────────────────────────────────
            [
                'type'        => 'gallery_preview',
                'title'       => 'Campus Life',
                'subtitle'    => null,
                'content'     => null,
                'button_text' => 'View Gallery',
                'button_url'  => '/gallery',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 8,
                'extra'       => null,
            ],

            // ── 10. TESTIMONIALS ──────────────────────────────────────────────
            [
                'type'        => 'testimonial_slider',
                'title'       => 'What Parents & Alumni Say',
                'subtitle'    => null,
                'content'     => null,
                'button_text' => null,
                'button_url'  => null,
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 9,
                'extra'       => null,
            ],

            // ── 11. CONTACT STRIP ─────────────────────────────────────────────
            [
                'type'        => 'contact_strip',
                'title'       => 'Get in Touch',
                'subtitle'    => 'We\'d love to hear from you. Reach out to our team for admissions, enquiries, or campus visits.',
                'content'     => null,
                'button_text' => 'Contact Us',
                'button_url'  => '/contact',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 10,
                'extra'       => null,
            ],

            // ── 12. CTA BANNER ────────────────────────────────────────────────
            [
                'type'        => 'cta_banner',
                'title'       => 'Join Our Learning Community',
                'subtitle'    => 'Give your child the gift of quality education grounded in human values. Admissions are now open!',
                'content'     => null,
                'button_text' => 'Apply Now',
                'button_url'  => '/admissions',
                'image_path'  => null,
                'is_visible'  => true,
                'order'       => 11,
                'extra'       => null,
            ],

        ];

        foreach ($blocks as $data) {
            PageBlock::create(array_merge($data, ['page_id' => null]));
        }

        // Clear cache so fresh data is used immediately
        Cache::forget('homepage_blocks');

        $this->command->info('✓ ' . count($blocks) . ' homepage blocks seeded.');
    }
}
