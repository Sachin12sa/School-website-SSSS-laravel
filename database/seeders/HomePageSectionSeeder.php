<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class HomePageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $check = 'M5 13l4 4L19 7';
        $heart = 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
        $book = 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253';
        $home = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3';

        $sections = [
            ['stats', null, null, null, [
                ['value' => '500+', 'label' => 'Students', 'icon' => $check],
                ['value' => '40+', 'label' => 'Teachers', 'icon' => $book],
                ['value' => '26+', 'label' => 'Years', 'icon' => $home],
                ['value' => '4', 'label' => 'Programs', 'icon' => $check],
            ], ['background' => 'navy', 'class' => '!py-10']],
            ['image-right', 'Who We Are', 'About Sathya Sai Shiksha Sadan', '<p>At Sathya Sai Shiksha Sadan, we believe education extends beyond textbooks. Our mission is to nurture young minds with academic excellence and human values.</p><p>From primary education through higher secondary (+2), we provide a supportive environment where students develop intellectually, emotionally, and morally.</p>', [
                ['title' => 'Value-based learning', 'description' => 'Education rooted in Sathya, Dharma, Shanti, Prema, and Ahimsa.', 'icon' => $heart],
                ['title' => 'Personal attention', 'description' => 'Dedicated faculty guide each child with care.', 'icon' => $check],
            ], ['background' => 'cream', 'image' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=900', 'image_alt' => 'Students learning']],
            ['program-cards', 'What We Offer', 'Our Academic Programs', 'Comprehensive education from foundation to specialisation, designed to unlock every student\'s potential.', [
                ['title' => 'Primary Level', 'badge' => 'Grades 1-5', 'description' => 'Building strong foundations in core subjects with focus on holistic development.', 'color' => 'var(--gold)', 'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=900', 'url' => '/programs#primary'],
                ['title' => 'Middle School', 'badge' => 'Grades 6-8', 'description' => 'Guided transition years that strengthen confidence, curiosity, and independent study habits.', 'color' => 'var(--navy)', 'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=900', 'url' => '/programs#middle'],
                ['title' => 'Secondary Level', 'badge' => 'Grades 9-10', 'description' => 'Focused academic preparation with values, discipline, and examination readiness.', 'color' => 'var(--lotus-red)', 'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=900', 'url' => '/programs#secondary'],
                ['title' => '+2 Science & Mgmt', 'badge' => 'Grades 11-12', 'description' => 'Specialised streams in Science and Management for confident future pathways.', 'color' => 'var(--gold-dark)', 'image' => 'https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=900', 'url' => '/programs#science'],
            ], ['background' => 'white', 'grid' => 'sm:grid-cols-2 xl:grid-cols-4']],
            ['image-left', 'Our Philosophy', 'Five Human Values', 'Our educational philosophy is built on five pillars that shape character and guide every student\'s growth.', [
                ['title' => 'Truth (Sathya)', 'description' => 'Honesty and integrity in thought, word, and deed.', 'icon' => $heart],
                ['title' => 'Right Conduct (Dharma)', 'description' => 'Moral and ethical behavior in all situations.', 'icon' => $check],
                ['title' => 'Peace (Shanti)', 'description' => 'Inner harmony and calm disposition.', 'icon' => $book],
                ['title' => 'Love & Non-Violence', 'description' => 'Compassion, service, and respect for all life.', 'icon' => $heart],
            ], ['background' => 'cream', 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=900', 'image_alt' => 'Campus values']],
            ['timeline', 'Our Story', 'A Legacy of Excellence', null, [
                ['title' => 'Milestones', 'items' => [
                    ['year' => '2000', 'text' => 'Sathya Sai Shiksha Sadan established with a vision of value-based education'],
                    ['year' => '2005', 'text' => 'Expanded to secondary level'],
                    ['year' => '2010', 'text' => '+2 Science stream introduced'],
                    ['year' => '2015', 'text' => '+2 Management stream launched'],
                    ['year' => '2026', 'text' => '26 proud years of nurturing excellence and human values'],
                ]],
            ], ['background' => 'white', 'columns' => 'sm:grid-cols-1']],
            ['cards', 'Reach Out', 'Get in Touch', null, [
                ['title' => 'Call Us', 'description' => '+977-1-XXXXXXX', 'icon' => 'M3 5a2 2 0 012-2h3.28', 'color' => 'var(--vivid-red)'],
                ['title' => 'Email Us', 'description' => 'info@school.edu', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8', 'color' => 'var(--gold)'],
                ['title' => 'Visit Us', 'description' => 'Sathya Sai Shiksha Sadan, Nepal', 'icon' => $home, 'color' => 'var(--navy)'],
            ], ['background' => 'cream', 'grid' => 'md:grid-cols-3']],
            ['cta', 'Join Our Community', 'Join Our Learning Community', 'Give your child the gift of quality education grounded in human values. Admissions are now open.', [
                ['label' => 'Apply Now', 'url' => '/admissions'],
                ['label' => 'Contact Us', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'dark', 'particle_type' => 'soft']],
        ];

        PageSection::where('page_key', 'home')->delete();

        foreach ($sections as $order => [$layout, $badge, $title, $content, $items, $settings]) {
            PageSection::create([
                'page_key' => 'home',
                'layout' => $layout,
                'badge_text' => $badge,
                'title' => $title,
                'content' => $content,
                'items' => $items ?: null,
                'settings' => $settings ?: null,
                'order' => $order,
                'is_published' => true,
            ]);
        }

        Cache::forget('sections_home');
        $this->command->info('Home page sections seeded.');
    }
}
