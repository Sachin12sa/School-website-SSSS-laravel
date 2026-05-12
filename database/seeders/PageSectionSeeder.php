<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $pages = ['home', 'about', 'programs', 'life-at-ssss', 'boarding', 'transport', 'contact', 'admissions'];
        PageSection::whereIn('page_key', $pages)->delete();

        $check = 'M5 13l4 4L19 7';
        $heart = 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
        $book = 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
        $home = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6';
        $bus = 'M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z M15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z';

        $sections = [
            ['home', 'stats', null, null, null, [
                ['value' => '500+', 'label' => 'Students', 'icon' => $check],
                ['value' => '40+', 'label' => 'Teachers', 'icon' => $book],
                ['value' => '26+', 'label' => 'Years', 'icon' => $home],
                ['value' => '4', 'label' => 'Programs', 'icon' => $check],
            ], ['background' => 'navy', 'class' => '!py-10']],
            ['home', 'image-right', 'Who We Are', 'About Sathya Sai Shiksha Sadan', '<p>At Sathya Sai Shiksha Sadan, we believe education extends beyond textbooks. Our mission is to nurture young minds with academic excellence and human values.</p><p>From primary education through higher secondary (+2), we provide a supportive environment where students develop intellectually, emotionally, and morally.</p>', [
                ['title' => 'Value-based learning', 'description' => 'Education rooted in Sathya, Dharma, Shanti, Prema, and Ahimsa.', 'icon' => $heart],
                ['title' => 'Personal attention', 'description' => 'Dedicated faculty guide each child with care.', 'icon' => $check],
            ], ['background' => 'cream', 'image' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=900', 'image_alt' => 'Students learning']],
            ['home', 'program-cards', 'What We Offer', 'Our Academic Programs', 'Comprehensive education from foundation to specialisation, designed to unlock every student\'s potential.', [
                ['title' => 'Primary Level', 'badge' => 'Grades 1-5', 'description' => 'Building strong foundations in core subjects with focus on holistic development.', 'color' => 'var(--gold)', 'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=900', 'url' => '/programs#primary'],
                ['title' => 'Middle School', 'badge' => 'Grades 6-8', 'description' => 'Guided transition years that strengthen confidence, curiosity, and independent study habits.', 'color' => 'var(--navy)', 'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=900', 'url' => '/programs#middle'],
                ['title' => 'Secondary Level', 'badge' => 'Grades 9-10', 'description' => 'Focused academic preparation with values, discipline, and examination readiness.', 'color' => 'var(--lotus-red)', 'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=900', 'url' => '/programs#secondary'],
                ['title' => '+2 Science & Mgmt', 'badge' => 'Grades 11-12', 'description' => 'Specialised streams in Science and Management for confident future pathways.', 'color' => 'var(--gold-dark)', 'image' => 'https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=900', 'url' => '/programs#science'],
            ], ['background' => 'white', 'grid' => 'sm:grid-cols-2 xl:grid-cols-4']],
            ['home', 'image-left', 'Our Philosophy', 'Five Human Values', 'Our educational philosophy is built on five pillars that shape character and guide every student\'s growth.', [
                ['title' => 'Truth (Sathya)', 'description' => 'Honesty and integrity in thought, word, and deed.', 'icon' => $heart],
                ['title' => 'Right Conduct (Dharma)', 'description' => 'Moral and ethical behavior in all situations.', 'icon' => $check],
                ['title' => 'Peace (Shanti)', 'description' => 'Inner harmony and calm disposition.', 'icon' => $book],
                ['title' => 'Love & Non-Violence', 'description' => 'Compassion, service, and respect for all life.', 'icon' => $heart],
            ], ['background' => 'cream', 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=900', 'image_alt' => 'Campus values']],
            ['home', 'timeline', 'Our Story', 'A Legacy of Excellence', null, [
                ['title' => 'Milestones', 'items' => [
                    ['year' => '2000', 'text' => 'Sathya Sai Shiksha Sadan established with a vision of value-based education'],
                    ['year' => '2005', 'text' => 'Expanded to secondary level'],
                    ['year' => '2010', 'text' => '+2 Science stream introduced'],
                    ['year' => '2015', 'text' => '+2 Management stream launched'],
                    ['year' => '2026', 'text' => '26 proud years of nurturing excellence and human values'],
                ]],
            ], ['background' => 'white', 'columns' => 'sm:grid-cols-1']],
            ['home', 'cards', 'Reach Out', 'Get in Touch', null, [
                ['title' => 'Call Us', 'description' => '+977-1-XXXXXXX', 'icon' => 'M3 5a2 2 0 012-2h3.28', 'color' => 'var(--vivid-red)'],
                ['title' => 'Email Us', 'description' => 'info@school.edu', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8', 'color' => 'var(--gold)'],
                ['title' => 'Visit Us', 'description' => 'Sathya Sai Shiksha Sadan, Nepal', 'icon' => $home, 'color' => 'var(--navy)'],
            ], ['background' => 'cream', 'grid' => 'md:grid-cols-3']],
            ['home', 'cta', 'Join Our Community', 'Join Our Learning Community', 'Give your child the gift of quality education grounded in human values. Admissions are now open.', [
                ['label' => 'Apply Now', 'url' => '/admissions'],
                ['label' => 'Contact Us', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'dark', 'particle_type' => 'soft']],

            ['about', 'default', 'Why We Exist', 'Our Mission', 'Sathya Sai Shiksha Sadan is dedicated to providing quality education that nurtures academic excellence and character through Truth, Right Conduct, Peace, Love, and Non-Violence.<br><br>We develop the whole person intellectually, emotionally, physically, and spiritually so students become responsible citizens with strong moral foundations.', [], ['background' => 'white']],
            ['about', 'cards', 'Our Philosophy', 'Five Human Values', null, [
                ['title' => 'Truth (Sathya)', 'description' => 'We cultivate honesty and integrity in all aspects of student life.', 'icon' => $heart],
                ['title' => 'Right Conduct (Dharma)', 'description' => 'We instill moral and ethical behavior through example and practice.', 'icon' => $check],
                ['title' => 'Peace (Shanti)', 'description' => 'We nurture inner harmony and peaceful coexistence among students.', 'icon' => $book],
                ['title' => 'Love & Non-Violence', 'description' => 'We promote compassion, service, and respect for all life.', 'icon' => $heart],
            ], ['background' => 'cream', 'grid' => 'sm:grid-cols-2 lg:grid-cols-4', 'card_class' => 'value-card']],
            ['about', 'image-right', 'Our Story', 'Our Journey', 'Since our establishment in 2000, Sathya Sai Shiksha Sadan has been committed to holistic education that combines academic rigour with character development.', [
                ['title' => '2000', 'description' => 'Sathya Sai Shiksha Sadan established', 'icon' => $check],
                ['title' => '2005', 'description' => 'Expanded to secondary level', 'icon' => $check],
                ['title' => '2010', 'description' => '+2 Science program introduced', 'icon' => $check],
                ['title' => '2015', 'description' => '+2 Management program launched', 'icon' => $check],
            ], ['background' => 'white', 'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=900', 'image_alt' => 'Our journey']],
            ['about', 'cards', 'Campus', 'Our Facilities', null, [
                ['title' => 'Modern Classrooms', 'description' => 'Spacious classrooms equipped for active learning.', 'icon' => $home],
                ['title' => 'Science Laboratories', 'description' => 'Physics, Chemistry, and Biology labs for practical work.', 'icon' => $check],
                ['title' => 'Library & Computer Lab', 'description' => 'Books, digital tools, and guided research spaces.', 'icon' => $book],
            ], ['background' => 'cream']],
            ['about', 'cta', 'Be Part of SSSS', 'Ready to Begin Your Journey?', 'Join a school where excellence meets values. Our admissions team is here to help you find your path.', [
                ['label' => 'Apply for Admission', 'url' => '/admissions'],
                ['label' => 'Contact Us', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'dark', 'particle_type' => 'soft']],

            ['programs', 'stats', null, null, null, [
                ['value' => 'Qualified', 'label' => 'Teachers', 'icon' => $check],
                ['value' => 'Modern', 'label' => 'Curriculum', 'icon' => $book],
                ['value' => 'Science', 'label' => 'Labs', 'icon' => $check],
                ['value' => '100%', 'label' => 'Results Focus', 'icon' => $check],
            ], ['background' => 'navy', 'class' => '!py-10']],
            ['programs', 'program-tabs', 'What We Offer', 'Explore Our Programs', 'Choose your path from foundational school education to specialised higher secondary streams.', [
                ['key' => 'school', 'label' => 'School Level', 'title' => 'Primary & Secondary Level', 'badge' => 'Grades 1-10', 'description' => 'Foundation and advanced school curriculum with creativity, values, and examination readiness.', 'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=900', 'subjects' => [['name' => 'English'], ['name' => 'Mathematics'], ['name' => 'Science'], ['name' => 'Social Studies'], ['name' => 'Computer'], ['name' => 'Nepali/Hindi']]],
                ['key' => 'science', 'label' => '+2 Science', 'title' => '+2 Science Stream', 'badge' => 'Grades 11-12', 'description' => 'Rigorous NEB-aligned science curriculum for medical, engineering, and technical pathways.', 'image' => 'https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=900', 'subjects' => [['name' => 'Physics', 'description' => 'Mechanics, waves, optics, and modern physics'], ['name' => 'Chemistry'], ['name' => 'Biology'], ['name' => 'Mathematics'], ['name' => 'English']]],
                ['key' => 'management', 'label' => '+2 Management', 'title' => '+2 Management Stream', 'badge' => 'Grades 11-12', 'description' => 'Business and management curriculum for commerce, banking, and entrepreneurship.', 'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=900', 'color' => 'var(--navy)', 'badge_text_color' => '#fff', 'subjects' => [['name' => 'Business Studies'], ['name' => 'Accountancy'], ['name' => 'Economics'], ['name' => 'Business Mathematics'], ['name' => 'English']]],
            ], ['background' => 'white']],
            ['programs', 'cards', 'Holistic Development', 'Beyond Academics', null, [
                ['title' => 'Sports & Athletics', 'description' => 'Cricket, football, basketball, athletics, and indoor games.', 'color' => 'var(--gold)'],
                ['title' => 'Arts & Culture', 'description' => 'Music, dance, drama, art, and cultural celebrations.', 'color' => 'var(--navy)'],
                ['title' => 'Competitions', 'description' => 'Debates, quiz, science exhibitions, and essay writing.', 'color' => '#D97706'],
            ], ['background' => 'cream']],
            ['programs', 'cta', 'Start Your Journey', 'Ready to Join Us?', 'Discover the right program for your child. Our admissions team is here to guide you through every step.', [
                ['label' => 'Apply for Admission', 'url' => '/admissions'],
                ['label' => 'Contact Admissions', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'dark', 'particle_type' => 'soft']],

            ['life-at-ssss', 'default', 'Our Community', 'Beyond Textbooks', 'Life at SSSS offers students opportunities to explore interests, develop skills, build character, and grow into well-rounded individuals.', [], ['background' => 'white']],
            ['life-at-ssss', 'video', 'Virtual Tour', 'See Life at SSSS', 'Experience the vibrant learning community of Sathya Sai Shiksha Sadan.', [], ['background' => 'navy', 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=1200', 'play_label' => 'Watch Campus Tour']],
            ['life-at-ssss', 'cards', 'What We Do', 'Student Activities', null, [
                ['title' => 'Music & Dance', 'description' => 'Traditional and modern music, dance classes and performances.', 'tag' => 'Weekly Classes', 'icon' => $book],
                ['title' => 'Sports & Athletics', 'description' => 'Cricket, football, basketball, athletics, and indoor games.', 'tag' => '10+ Sports', 'icon' => $check, 'color' => 'var(--navy)'],
                ['title' => 'Arts & Craft', 'description' => 'Drawing, painting, handicrafts, and creative expression.', 'tag' => 'Art Programs', 'icon' => $heart, 'color' => '#D97706'],
                ['title' => 'Value Education', 'description' => 'Daily prayers, meditation, and character development sessions.', 'tag' => 'Daily Practice', 'icon' => $heart],
                ['title' => 'Literary Activities', 'description' => 'Debates, elocution, essay writing, and quiz competitions.', 'tag' => 'Regular Events', 'icon' => $book, 'color' => 'var(--navy)'],
                ['title' => 'Cultural Programs', 'description' => 'Annual day, festivals, and cultural celebrations.', 'tag' => 'Year-round', 'icon' => $heart, 'color' => '#D97706'],
            ], ['background' => 'white', 'card_class' => 'activity-card']],
            ['life-at-ssss', 'image-left', 'Residential Life', 'Boarding at SSSS', 'Our residential boarding facility provides a safe, nurturing home-away-from-home for students.', [
                ['title' => 'Comfortable Dorms', 'description' => 'Spacious, well-ventilated rooms', 'icon' => $home],
                ['title' => 'Nutritious Meals', 'description' => 'Freshly prepared vegetarian meals', 'icon' => $check],
                ['title' => 'Study Facilities', 'description' => 'Supervised evening study hours', 'icon' => $book],
                ['title' => '24/7 Supervision', 'description' => 'Trained resident housemasters', 'icon' => $check],
            ], ['background' => 'cream', 'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900']],
            ['life-at-ssss', 'cta', 'Join SSSS', 'Ready to Be Part of SSSS?', 'Join our vibrant community and experience education that nurtures the whole child.', [
                ['label' => 'Apply for Admission', 'url' => '/admissions'],
            ], ['background' => 'white', 'particle_type' => 'geometric']],

            ['boarding', 'stats', null, null, null, [
                ['value' => '2', 'label' => 'Hostel Blocks', 'icon' => $home],
                ['value' => '24/7', 'label' => 'Staff Supervision', 'icon' => $check],
                ['value' => '3+', 'label' => 'Meals Daily', 'icon' => $check],
                ['value' => 'Daily', 'label' => 'Study Hours', 'icon' => $book],
            ], ['background' => 'navy', 'class' => '!py-10']],
            ['boarding', 'image-right', 'Why Choose SSSS Boarding?', 'A Home Away From Home', 'Our boarding programme provides a structured, value-based residential experience with disciplined routines, peer learning, and dedicated housemaster guidance.', [
                ['title' => 'Comfortable Dormitories', 'description' => 'Spacious rooms with study desks and secure storage.', 'icon' => $home],
                ['title' => 'Nutritious Meals', 'description' => 'Freshly prepared vegetarian meals daily.', 'icon' => $check],
                ['title' => 'Study Facilities', 'description' => 'Quiet study halls with supervised study hours.', 'icon' => $book],
                ['title' => '24/7 Supervision', 'description' => 'Round-the-clock care by trained resident staff.', 'icon' => $check],
            ], ['background' => 'white', 'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900']],
            ['boarding', 'cards', 'Our Facilities', 'Hostel Blocks', null, [
                ['title' => 'Boys Hostel', 'description' => 'A structured residential block designed to foster academic focus and character development.', 'icon' => $home],
                ['title' => 'Girls Hostel', 'description' => 'A warm, supportive residential environment guided by experienced female staff.', 'icon' => $home],
            ], ['background' => 'cream', 'grid' => 'md:grid-cols-2']],
            ['boarding', 'timeline', 'Structure & Discipline', 'Boarding Daily Routine', null, [
                ['title' => 'Morning Routine', 'items' => [['time' => '5:30 AM', 'text' => 'Wake Up & Personal Care'], ['time' => '6:00 AM', 'text' => 'Morning Prayer & Meditation'], ['time' => '7:30 AM', 'text' => 'Breakfast'], ['time' => '8:00 AM', 'text' => 'School Classes Begin']]],
                ['title' => 'Evening Routine', 'items' => [['time' => '3:30 PM', 'text' => 'School Ends / Free Time', 'color' => 'var(--navy)'], ['time' => '6:00 PM', 'text' => 'Supervised Study Hour', 'color' => 'var(--navy)'], ['time' => '8:00 PM', 'text' => 'Dinner', 'color' => 'var(--navy)'], ['time' => '9:30 PM', 'text' => 'Lights Out', 'color' => '#6b7280']]],
            ], ['background' => 'white']],
            ['boarding', 'cta', 'Boarding Admissions', 'Interested in Residential Life?', 'Talk to our team about availability, routines, and admission requirements for boarding students.', [
                ['label' => 'Apply for Boarding', 'url' => '/admissions'],
                ['label' => 'Contact Boarding Office', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'dark']],

            ['transport', 'stats', null, null, null, [
                ['value' => '8+', 'label' => 'Buses in Fleet', 'icon' => $bus],
                ['value' => '12', 'label' => 'Active Routes', 'icon' => $check],
                ['value' => '200+', 'label' => 'Students Covered', 'icon' => $home],
                ['value' => '15 km', 'label' => 'Max Coverage', 'icon' => $check],
            ], ['background' => 'navy', 'class' => '!py-10']],
            ['transport', 'steps', 'Smart Attendance & Notifications', 'How Our System Works', 'From boarding to safe drop-off, every step is tracked, logged, and communicated.', [
                ['step' => '01', 'title' => 'Student Boards Bus', 'description' => 'Student taps ID card on the bus scanner.', 'icon' => $bus, 'color' => 'var(--navy)'],
                ['step' => '02', 'title' => 'Attendance Marked', 'description' => 'Attendance is automatically logged.', 'icon' => $check],
                ['step' => '03', 'title' => 'Parent Notified', 'description' => 'Parents receive an instant notification.', 'icon' => $check, 'color' => '#059669'],
                ['step' => '04', 'title' => 'Safely Dropped Off', 'description' => 'Confirmation is sent after arrival.', 'icon' => $home, 'color' => '#3B82F6'],
            ], ['background' => 'cream']],
            ['transport', 'cards', 'Comprehensive Safety System', 'Safety is Never Optional', null, [
                ['title' => 'Verified Drivers', 'description' => 'Background checks, license verification, and safe-driving assessments.', 'icon' => $check, 'color' => '#3B82F6'],
                ['title' => 'Speed Monitoring', 'description' => 'Real-time GPS speed tracking with instant alerts.', 'icon' => $check, 'color' => '#EF4444'],
                ['title' => 'CCTV Surveillance', 'description' => 'HD cameras installed inside buses for administration review.', 'icon' => $check, 'color' => '#9333EA'],
            ], ['background' => 'white']],
            ['transport', 'routes', 'Where We Go', 'Routes & Coverage', null, [
                ['title' => 'Route A', 'badge' => 'SSSS-01 & 02', 'color' => '#3B82F6', 'bg' => '#DBEAFE', 'details' => ['Coverage Area' => 'North Sector', 'Stops' => '7 stops', 'Students' => '42', 'Departure' => '7:15 AM']],
                ['title' => 'Route B', 'badge' => 'SSSS-03 & 04', 'color' => '#059669', 'bg' => '#D1FAE5', 'details' => ['Coverage Area' => 'East Zone', 'Stops' => '9 stops', 'Students' => '54', 'Departure' => '7:20 AM']],
                ['title' => 'Route C', 'badge' => 'SSSS-05 & 06', 'color' => '#9333EA', 'bg' => '#EDE9FE', 'details' => ['Coverage Area' => 'West & South', 'Stops' => '8 stops', 'Students' => '48', 'Departure' => '7:10 AM']],
            ], ['background' => 'cream']],
            ['transport', 'cta', '2026-27 Registration', 'Register for School Transportation', 'Ensure your child travels safely every day. Limited seats are available per route.', [
                ['label' => 'Apply for Transportation', 'url' => '/admissions'],
                ['label' => 'Contact Transport Office', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'white', 'particle_type' => 'geometric']],

            ['contact', 'cards', 'Reach Us', 'Contact Information', null, [
                ['title' => 'Visit Us', 'description' => 'Sathya Sai Shiksha Sadan, Nepal', 'icon' => $home, 'color' => '#e53e3e'],
                ['title' => 'Call Us', 'description' => '+977-1-XXXXXXX', 'icon' => 'M3 5a2 2 0 012-2h3.28', 'color' => 'var(--navy)'],
                ['title' => 'Email Us', 'description' => 'info@sathyasaishiksha.edu.np', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8', 'color' => '#D97706'],
                ['title' => 'Office Hours', 'description' => 'Mon-Fri: 8:00 AM - 4:00 PM. Saturday: 8:00 AM - 1:00 PM', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0', 'color' => '#059669'],
            ], ['background' => 'white', 'grid' => 'sm:grid-cols-2 lg:grid-cols-4']],
            ['contact', 'cards', 'Directory', 'Department Directory', null, [
                ['title' => 'Admissions Office', 'description' => 'admissions@sathyasaishiksha.edu.np | +977-1-XXXXXXX', 'icon' => $check],
                ['title' => 'Principal Office', 'description' => 'principal@sathyasaishiksha.edu.np | +977-1-XXXXXXX', 'icon' => $book],
                ['title' => 'Accounts Department', 'description' => 'accounts@sathyasaishiksha.edu.np | +977-1-XXXXXXX', 'icon' => $check],
                ['title' => 'Academic Coordinator', 'description' => 'academics@sathyasaishiksha.edu.np | +977-1-XXXXXXX', 'icon' => $book],
                ['title' => 'Transport Coordinator', 'description' => 'transport@sathyasaishiksha.edu.np | +977-1-XXXXXXX', 'icon' => $bus],
                ['title' => 'IT Support', 'description' => 'it@sathyasaishiksha.edu.np | +977-1-XXXXXXX', 'icon' => $check],
            ], ['background' => 'cream', 'grid' => 'sm:grid-cols-2 lg:grid-cols-3']],
            ['contact', 'cta', 'Still Have Questions?', 'We Would Love to Hear From You', 'Send your message through the contact form below and our team will reply as soon as possible.', [
                ['label' => 'Go to Contact Form', 'url' => '#contact-form'],
                ['label' => 'Admissions', 'url' => '/admissions', 'style' => 'ghost'],
            ], ['background' => 'dark', 'particle_type' => 'soft', 'padding' => 'py-16 lg:py-20']],

            ['admissions', 'steps', 'How to Apply', 'Admission Process', 'A simple, guided process from enquiry to confirmation.', [
                ['step' => '01', 'title' => 'Submit Application', 'description' => 'Complete the online form with student and guardian details.', 'icon' => $book, 'color' => 'var(--gold)'],
                ['step' => '02', 'title' => 'Share Documents', 'description' => 'Submit required documents to the admissions office.', 'icon' => $check, 'color' => 'var(--navy)'],
                ['step' => '03', 'title' => 'Entrance Review', 'description' => 'Students complete assessment or interaction as applicable.', 'icon' => $book, 'color' => '#1a237e'],
                ['step' => '04', 'title' => 'Confirmation', 'description' => 'Receive confirmation and complete enrollment formalities.', 'icon' => $check, 'color' => '#059669'],
            ], ['background' => 'white']],
            ['admissions', 'cards', 'What to Bring', 'Required Documents', null, [
                ['title' => 'Primary Level', 'description' => 'Birth certificate, photos, previous report card, transfer certificate if applicable.', 'icon' => $book, 'color' => 'var(--gold)'],
                ['title' => 'Secondary Level', 'description' => 'Mark sheets, transfer certificate, character certificate, birth certificate, photos.', 'icon' => $check, 'color' => 'var(--navy)'],
                ['title' => '+2 Level', 'description' => 'Grade 10 mark sheet, transfer certificate, character certificate, migration if needed.', 'icon' => $book, 'color' => '#DC2626'],
            ], ['background' => 'cream']],
            ['admissions', 'timeline', 'Key Information', 'Dates & Session Details', null, [
                ['title' => 'Admission Timeline', 'items' => [['time' => 'Jan 15', 'text' => 'Form distribution starts'], ['time' => 'Mar 15', 'text' => 'Last date for submission'], ['time' => 'Mar 25', 'text' => 'Entrance test'], ['time' => 'Apr 1', 'text' => 'Results announcement']]],
                ['title' => 'Session Details', 'items' => [['time' => 'Apr 10-12', 'text' => 'Orientation program', 'color' => 'var(--navy)'], ['time' => 'Apr 15', 'text' => 'Academic year begins', 'color' => 'var(--navy)'], ['time' => '8 AM-4 PM', 'text' => 'Office hours', 'color' => '#059669']]],
            ], ['background' => 'white']],
            ['admissions', 'cta', 'Come See Us', 'Visit Our Campus', 'Schedule a campus tour, meet our teachers, and experience the SSSS community first-hand.', [
                ['label' => 'Apply Online Now', 'url' => '#form'],
                ['label' => 'Schedule a Visit', 'url' => '/contact', 'style' => 'ghost'],
            ], ['background' => 'dark', 'particle_type' => 'soft', 'padding' => 'py-16 lg:py-20']],
        ];

        foreach ($sections as $order => [$pageKey, $layout, $badge, $title, $content, $items, $settings]) {
            PageSection::create([
                'page_key' => $pageKey,
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

        foreach ($pages as $page) {
            Cache::forget("sections_{$page}");
        }

        $this->command->info('PageSection: ' . count($sections) . ' sections seeded.');
    }
}
