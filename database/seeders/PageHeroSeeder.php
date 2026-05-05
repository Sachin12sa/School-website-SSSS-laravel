<?php

namespace Database\Seeders;

use App\Models\PageHero;
use Illuminate\Database\Seeder;

class PageHeroSeeder extends Seeder
{
    public function run(): void
    {
        $heroes = [

            // ── HOME ───────────────────────────────────────────────────
            [
                'page_slug'              => 'home',
                'page_label'             => 'Home Page Hero',
                'badge_text'             => 'Grade 1 to +2 Level · Value-Based Education',
                'heading'                => 'Sathya Sai Shiksha Sadan',
                'subheading'             => 'Nurturing excellence and character from Grade 1 to +2 with dedicated focus on holistic development and human values.',
                'primary_button_text'    => 'Apply for Admission',
                'primary_button_url'     => '/admissions',
                'secondary_button_text'  => 'Learn More',
                'secondary_button_url'   => '/about',
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'white',
                'min_height'             => '100dvh',
                'text_align'             => 'center',
                'show_rings'             => false,
                'stats'                  => [
                    ['value' => '500+', 'label' => 'Students'],
                    ['value' => '40+',  'label' => 'Teachers'],
                    ['value' => '26',   'label' => 'Years'],
                    ['value' => '3',    'label' => 'Programmes'],
                ],
                'meta_title'             => 'Sathya Sai Shiksha Sadan — Education in Human Values',
                'meta_description'       => 'Sathya Sai Shiksha Sadan: a value-based school from Grade 1 to +2. Admissions open for 2026–27.',
                'is_active'              => true,
            ],

            // ── ABOUT ──────────────────────────────────────────────────
            [
                'page_slug'              => 'about',
                'page_label'             => 'About Us Hero',
                'badge_text'             => 'Transforming Lives Since 2000',
                'heading'                => 'About Us',
                'subheading'             => 'Education in Human Values — a place where every student is seen, valued, and guided to grow.',
                'primary_button_text'    => null,
                'primary_button_url'     => null,
                'secondary_button_text'  => null,
                'secondary_button_url'   => null,
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'white',
                'min_height'             => '68vh',
                'text_align'             => 'center',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'About Us — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'Learn about our mission, values, and 26-year journey of value-based education.',
                'is_active'              => true,
            ],

            // ── PROGRAMS ───────────────────────────────────────────────
            [
                'page_slug'              => 'programs',
                'page_label'             => 'Academic Programs Hero',
                'badge_text'             => 'Grade 1 to +2 Level',
                'heading'                => 'Academic Programs',
                'subheading'             => 'Comprehensive education from foundation to specialisation, unlocking every student\'s potential.',
                'primary_button_text'    => null,
                'primary_button_url'     => null,
                'secondary_button_text'  => null,
                'secondary_button_url'   => null,
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'gold',
                'min_height'             => '68vh',
                'text_align'             => 'center',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'Academic Programs — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'Explore our Primary, Secondary, +2 Science and +2 Management programs.',
                'is_active'              => true,
            ],

            // ── LIFE AT SSSS ───────────────────────────────────────────
            [
                'page_slug'              => 'life-at-ssss',
                'page_label'             => 'Life at SSSS Hero',
                'badge_text'             => 'A Holistic Learning Environment',
                'heading'                => 'Life at SSSS',
                'subheading'             => 'Beyond academics — a vibrant, nurturing community where students grow, create, and shine.',
                'primary_button_text'    => null,
                'primary_button_url'     => null,
                'secondary_button_text'  => null,
                'secondary_button_url'   => null,
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'white',
                'min_height'             => '68vh',
                'text_align'             => 'center',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'Life at SSSS — Activities, Sports & Culture',
                'meta_description'       => 'Discover student life at SSSS — sports, arts, music, boarding, and annual events.',
                'is_active'              => true,
            ],

            // ── BOARDING ───────────────────────────────────────────────
            [
                'page_slug'              => 'boarding',
                'page_label'             => 'Boarding Facility Hero',
                'badge_text'             => 'Residential Facility',
                'heading'                => 'Boarding at SSSS',
                'subheading'             => 'A safe, nurturing home-away-from-home where students grow academically, spiritually, and personally.',
                'primary_button_text'    => 'Apply for Boarding',
                'primary_button_url'     => '/admissions',
                'secondary_button_text'  => 'Contact Boarding Office',
                'secondary_button_url'   => '/contact',
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.30,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'gold',
                'min_height'             => '72vh',
                'text_align'             => 'left',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'Boarding Facility — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'Safe residential boarding at SSSS — structured routines, nutritious meals, and 24/7 supervision.',
                'is_active'              => true,
            ],

            // ── ADMISSIONS ─────────────────────────────────────────────
            [
                'page_slug'              => 'admissions',
                'page_label'             => 'Admissions Hero',
                'badge_text'             => 'Admissions 2026–27 Open',
                'heading'                => 'Apply to SSSS',
                'subheading'             => 'Join our community of learners and begin a journey of excellence, character, and human values.',
                'primary_button_text'    => 'Apply Online Now',
                'primary_button_url'     => '#form',
                'secondary_button_text'  => 'Required Documents',
                'secondary_button_url'   => '#documents',
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.20,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'gold',
                'min_height'             => '68vh',
                'text_align'             => 'center',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'Admissions — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'Apply for admission to SSSS. Admissions open for 2026–27 academic year.',
                'is_active'              => true,
            ],

            // ── TRANSPORT ──────────────────────────────────────────────
            [
                'page_slug'              => 'transport',
                'page_label'             => 'Transportation Hero',
                'badge_text'             => 'GPS-Enabled & Actively Monitored',
                'heading'                => 'Safe, Smart & Monitored School Transportation',
                'subheading'             => 'Every journey is GPS-tracked, every student is accounted for, and every parent stays informed — in real time.',
                'primary_button_text'    => 'View Routes',
                'primary_button_url'     => '#routes',
                'secondary_button_text'  => 'Register Now',
                'secondary_button_url'   => '#register',
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'white',
                'min_height'             => '72vh',
                'text_align'             => 'left',
                'show_rings'             => false,
                'stats'                  => [
                    ['value' => '8+',   'label' => 'Buses'],
                    ['value' => '200+', 'label' => 'Students'],
                    ['value' => '100%', 'label' => 'GPS Covered'],
                ],
                'meta_title'             => 'School Transportation — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'GPS-tracked, safe school transport at SSSS. Real-time parent notifications.',
                'is_active'              => true,
            ],

            // ── CONTACT ────────────────────────────────────────────────
            [
                'page_slug'              => 'contact',
                'page_label'             => 'Contact Hero',
                'badge_text'             => 'We Are Here to Help',
                'heading'                => 'Contact Us',
                'subheading'             => 'Reach our admissions, transport, academic, and school office teams from one friendly place.',
                'primary_button_text'    => 'Send a Message',
                'primary_button_url'     => '#contact-form',
                'secondary_button_text'  => 'View Location',
                'secondary_button_url'   => '#map',
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'gold',
                'min_height'             => '68vh',
                'text_align'             => 'center',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'Contact Us — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'Contact Sathya Sai Shiksha Sadan for admissions, school visits, transport, accounts, and general enquiries.',
                'is_active'              => true,
            ],

            // ── TESTIMONIALS ──────────────────────────────────────────
            [
                'page_slug'              => 'testimonials',
                'page_label'             => 'Testimonials Hero',
                'badge_text'             => 'Parent & Student Voices',
                'heading'                => 'Testimonials',
                'subheading'             => 'Real experiences from families, students, and alumni who have grown with value-based education at SSSS.',
                'primary_button_text'    => 'Apply for Admission',
                'primary_button_url'     => '/admissions',
                'secondary_button_text'  => 'Contact Us',
                'secondary_button_url'   => '/contact',
                'bg_image_path'          => null,
                'bg_image_opacity'       => 0.22,
                'bg_overlay_style'       => 'dark',
                'badge_style'            => 'gold',
                'min_height'             => '68vh',
                'text_align'             => 'center',
                'show_rings'             => true,
                'stats'                  => null,
                'meta_title'             => 'Testimonials — Sathya Sai Shiksha Sadan',
                'meta_description'       => 'Read testimonials from parents, students, and alumni of Sathya Sai Shiksha Sadan.',
                'is_active'              => true,
            ],

        ];

        foreach ($heroes as $data) {
            PageHero::updateOrCreate(
                ['page_slug' => $data['page_slug']],
                $data
            );
        }

        $this->command->info('PageHero: ' . count($heroes) . ' heroes seeded.');
    }
}
