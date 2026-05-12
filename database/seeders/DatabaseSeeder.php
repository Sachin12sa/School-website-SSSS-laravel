<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, SiteSetting, Menu, MenuItem, Page, PageBlock, NewsPost, Event, Teacher, Faq, Gallery, Testimonial};
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ──────────────────────────────────────────────────────────
        User::create([
            'name'     => 'School Admin',
            'email'    => 'admin@school.edu',
            'password' => Hash::make('admin'),
            'role'     => 'admin',
        ]);

        // ─── Site Settings ────────────────────────────────────────────────────────
        $settings = [
            'school_name'      => 'Greenfield Academy',
            'school_tagline'   => 'Excellence in Education',
            'established_year' => '1980',
            'about_short'      => 'Committed to excellence in education, nurturing every student to achieve their highest potential in a vibrant and supportive community.',
            'address'          => '123 School Lane, Education City, Country',
            'phone'            => '+1 (234) 567-8900',
            'email'            => 'info@greenfieldacademy.edu',
            'facebook'         => 'https://facebook.com',
            'twitter'          => 'https://twitter.com',
            'instagram'        => 'https://instagram.com',
            'youtube'          => 'https://youtube.com',
            'meta_description' => 'Greenfield Academy — a leading school committed to academic excellence, character development, and holistic student growth.',
            'hero_subtitle'    => 'Nurturing young minds, building strong characters, and inspiring a lifelong love of learning in every student we serve.',
            'about_content'    => '<p>Greenfield Academy has been at the forefront of quality education since 1980. We believe every child has unique potential, and our mission is to create an environment where that potential can flourish.</p><p>With a team of dedicated educators, modern facilities, and a curriculum designed for the future, we prepare our students not just for examinations, but for life.</p>',
        ];
        foreach ($settings as $key => $value) {
            SiteSetting::create(['key' => $key, 'value' => $value]);
        }

        // ─── Header Menu ──────────────────────────────────────────────────────────
        $menu = Menu::create(['name' => 'Main Menu', 'location' => 'header']);
        $items = [
            ['title' => 'Home',       'route_name' => 'home',           'order' => 0],
            ['title' => 'About',      'route_name' => 'page.show',      'url' => '/about',      'order' => 1],
            ['title' => 'Academics',  'route_name' => 'page.show',      'url' => '/academics',  'order' => 2],
            ['title' => 'Admissions', 'route_name' => 'admissions.index','order' => 3],
            ['title' => 'Faculty',    'route_name' => 'teachers.index',  'order' => 4],
            ['title' => 'News',       'route_name' => 'news.index',      'order' => 5],
            ['title' => 'Events',     'route_name' => 'events.index',    'order' => 6],
            ['title' => 'Gallery',    'route_name' => 'gallery.index',   'order' => 7],
            ['title' => 'Contact',    'route_name' => 'contact.index',   'order' => 8],
        ];
        foreach ($items as $item) {
            $item['menu_id'] = $menu->id;
            MenuItem::create($item);
        }

        // ─── Homepage Blocks ──────────────────────────────────────────────────────
        $blocks = [
            ['type' => 'hero',        'title' => 'Greenfield Academy', 'subtitle' => 'Nurturing young minds, building strong characters, and inspiring a lifelong love of learning in every student we serve.', 'button_text' => 'Discover More', 'button_url' => '/about', 'order' => 0, 'is_visible' => true],
            ['type' => 'stats',       'title' => 'Our Numbers', 'extra' => ['students' => '1,200+', 'teachers' => '80+', 'years' => '44+', 'programmes' => '20+'], 'order' => 1, 'is_visible' => true],
            ['type' => 'about_intro', 'title' => 'A Tradition of Academic Excellence', 'content' => '<p>Greenfield Academy has been at the forefront of quality education since 1980. We believe every child has unique potential, and our mission is to create an environment where that potential can flourish.</p><p>With a team of dedicated educators, modern facilities, and a curriculum designed for the future, we prepare our students not just for examinations, but for life.</p>', 'order' => 2, 'is_visible' => true],
            ['type' => 'news_feed',   'title' => 'Latest News',  'order' => 3, 'is_visible' => true],
            ['type' => 'events_feed', 'title' => 'Upcoming Events', 'order' => 4, 'is_visible' => true],
            ['type' => 'testimonial_slider', 'title' => 'What Our Community Says', 'order' => 5, 'is_visible' => true],
            ['type' => 'cta_banner',  'title' => 'Begin Your Journey With Us', 'subtitle' => 'Join our school family and unlock your child\'s full potential. Admissions are now open for the upcoming academic year.', 'button_text' => 'Apply Now', 'button_url' => '/admissions', 'order' => 6, 'is_visible' => true],
        ];
        foreach ($blocks as $block) {
            PageBlock::create($block);
        }

        // ─── Legacy CMS Pages (generic fallback content) ─────────────────────────
        Page::create(['title' => 'About Us', 'slug' => 'about', 'hero_title' => 'About Greenfield Academy', 'hero_subtitle' => 'Our story, our mission, our values.', 'content' => '<h2>Our Mission</h2><p>To provide a world-class education that equips every student with the knowledge, skills, values, and resilience to lead fulfilling and impactful lives.</p><h2>Our Vision</h2><p>To be recognised as a centre of excellence where every learner is inspired to achieve their personal best in a nurturing, inclusive, and innovative environment.</p><h2>Our History</h2><p>Founded in 1980 by a group of passionate educators, Greenfield Academy began as a small primary school with just 50 students. Today, we serve over 1,200 students from Nursery through to Year 12, with a faculty of more than 80 dedicated teaching professionals.</p>', 'is_published' => true, 'order' => 1]);
        Page::create(['title' => 'Academics', 'slug' => 'academics', 'hero_title' => 'Academic Programmes', 'hero_subtitle' => 'Rigorous, innovative, and student-centred.', 'content' => '<h2>Our Curriculum</h2><p>We offer a broad and balanced curriculum designed to challenge and inspire students at every stage of their education. From early childhood through to sixth form, our programmes are built around the belief that deep understanding matters more than rote memorisation.</p><h2>Programmes Offered</h2><ul><li>Early Years Foundation (Nursery–Reception)</li><li>Primary Education (Year 1–6)</li><li>Secondary Education (Year 7–11)</li><li>Sixth Form (Year 12–13)</li></ul>', 'is_published' => true, 'order' => 2]);

        // ─── News Posts ───────────────────────────────────────────────────────────
        $newsPosts = [
            ['title' => 'Greenfield Academy Tops National Exam Results', 'excerpt' => 'Our students have once again demonstrated outstanding academic achievement, with 96% achieving top grades across all subjects.', 'body' => '<p>We are delighted to announce that Greenfield Academy students have achieved exceptional results in this year\'s national examinations. A remarkable 96% of our students achieved top grades, placing us among the highest-performing schools in the country.</p><p>This achievement is a testament to the hard work of our students, the dedication of our teaching staff, and the unwavering support of our school community.</p>', 'category' => 'Academic', 'is_featured' => true, 'published_at' => Carbon::now()->subDays(2)],
            ['title' => 'New Science Laboratory Opens This Term', 'excerpt' => 'Our state-of-the-art science laboratory is now open, providing students with world-class facilities for practical learning.', 'body' => '<p>Greenfield Academy is proud to open its brand-new science laboratory, equipped with the latest technology and equipment to support hands-on learning in biology, chemistry, and physics.</p>', 'category' => 'Facilities', 'is_featured' => false, 'published_at' => Carbon::now()->subDays(7)],
            ['title' => 'Annual Sports Day: A Day of Champions', 'excerpt' => 'Students, parents, and staff came together for an unforgettable day of athletic competition and community spirit.', 'body' => '<p>Last Friday, Greenfield Academy hosted its annual Sports Day, and what a day it was! Students from all year groups competed in track and field events, team sports, and relay races.</p>', 'category' => 'Sports', 'is_featured' => false, 'published_at' => Carbon::now()->subDays(14)],
            ['title' => 'Year 10 Students Win Regional Debate Competition', 'excerpt' => 'Our debating team brought home the regional championship trophy, defeating 12 schools in the final.', 'body' => '<p>Congratulations to our Year 10 debating team who won the Regional Schools Debate Championship last weekend. The team argued brilliantly on the topic of climate policy.</p>', 'category' => 'Achievements', 'is_featured' => false, 'published_at' => Carbon::now()->subDays(20)],
        ];
        foreach ($newsPosts as $post) {
            NewsPost::create(array_merge($post, ['slug' => \Illuminate\Support\Str::slug($post['title']), 'is_published' => true]));
        }

        // ─── Events ───────────────────────────────────────────────────────────────
        $events = [
            ['title' => 'Open Day – Visit Our School', 'description' => 'Prospective families are invited to tour our campus, meet our teachers, and learn about admissions.', 'start_date' => Carbon::now()->addDays(10), 'location' => 'Main Campus', 'organizer' => 'Admissions Office'],
            ['title' => 'Annual Prize-Giving Ceremony', 'description' => 'Celebrating the achievements of our outstanding students across academic, sporting, and artistic endeavours.', 'start_date' => Carbon::now()->addDays(21), 'location' => 'School Auditorium', 'organizer' => 'School Administration'],
            ['title' => 'Inter-School Science Fair', 'description' => 'Students from 10 schools compete with innovative science projects judged by industry professionals.', 'start_date' => Carbon::now()->addDays(35), 'location' => 'Sports Hall', 'organizer' => 'Science Department'],
            ['title' => 'Parent-Teacher Conference', 'description' => 'Book a one-on-one session with your child\'s teachers to discuss progress and set goals for the term ahead.', 'start_date' => Carbon::now()->addDays(7), 'end_date' => Carbon::now()->addDays(8), 'location' => 'Classrooms', 'organizer' => 'Academic Office'],
        ];
        foreach ($events as $e) {
            Event::create(array_merge($e, ['slug' => \Illuminate\Support\Str::slug($e['title']), 'is_published' => true]));
        }

        // ─── Teachers ─────────────────────────────────────────────────────────────
        $teachers = [
            ['name' => 'Dr. Emily Watson', 'designation' => 'Headteacher', 'department' => 'Leadership', 'bio' => 'Dr. Watson has over 25 years of experience in education and holds a PhD in Educational Leadership from Oxford University. She joined Greenfield Academy in 2015 and has driven significant improvements in academic outcomes.', 'order' => 1],
            ['name' => 'Mr. James Hartley', 'designation' => 'Deputy Head – Academics', 'department' => 'Leadership', 'bio' => 'Mr. Hartley oversees the academic programme and curriculum development. He is passionate about innovative teaching methods and data-driven improvement.', 'order' => 2],
            ['name' => 'Ms. Priya Sharma', 'designation' => 'Head of Mathematics', 'department' => 'Mathematics', 'bio' => 'Ms. Sharma brings a passion for numbers and problem-solving to every lesson. Her students consistently achieve top marks in national examinations.', 'order' => 3],
            ['name' => 'Mr. Daniel Osei', 'designation' => 'Head of Science', 'department' => 'Sciences', 'bio' => 'Mr. Osei is a former research chemist who discovered his true calling in teaching. He makes science come alive through practical experiments and real-world applications.', 'order' => 4],
            ['name' => 'Mrs. Claire Beaumont', 'designation' => 'Head of English', 'department' => 'Humanities', 'bio' => 'Mrs. Beaumont has a lifelong love of literature and writing. She has published two collections of poetry and brings creative energy to every English lesson.', 'order' => 5],
            ['name' => 'Mr. Raj Patel', 'designation' => 'PE & Sports Coordinator', 'department' => 'Physical Education', 'bio' => 'Mr. Patel is a former professional athlete who channels his competitive spirit into inspiring students to reach their physical potential.', 'order' => 6],
        ];
        foreach ($teachers as $t) {
            Teacher::create(array_merge($t, ['is_published' => true]));
        }

        // ─── FAQs ─────────────────────────────────────────────────────────────────
        $faqs = [
            ['question' => 'What age groups does Greenfield Academy cater to?', 'answer' => 'We welcome students from age 3 (Nursery) through to age 18 (Year 13 / Sixth Form).', 'category' => 'General', 'order' => 1],
            ['question' => 'How do I apply for admission?', 'answer' => 'You can submit an online application through our Admissions page. Once submitted, our admissions team will contact you within 2–3 working days to guide you through the next steps.', 'category' => 'Admissions', 'order' => 2],
            ['question' => 'Is there an entrance examination?', 'answer' => 'For students applying to Year 7 and above, a short assessment in English and Mathematics may be required. This helps us understand how best to support each student.', 'category' => 'Admissions', 'order' => 3],
            ['question' => 'What school hours do you operate?', 'answer' => 'The school day runs from 8:00 AM to 3:30 PM, Monday to Friday. After-school clubs and activities run until 5:30 PM.', 'category' => 'General', 'order' => 4],
            ['question' => 'Do you offer scholarships or bursaries?', 'answer' => 'Yes, we offer merit-based scholarships for exceptional students and need-based bursaries for families who qualify. Please contact our admissions office for details.', 'category' => 'Admissions', 'order' => 5],
            ['question' => 'What extra-curricular activities are available?', 'answer' => 'We offer over 40 clubs and activities including robotics, debate, drama, music, art, a range of sports teams, and community volunteering programmes.', 'category' => 'Student Life', 'order' => 6],
        ];
        foreach ($faqs as $f) {
            Faq::create(array_merge($f, ['is_published' => true]));
        }

        // ─── Testimonials ─────────────────────────────────────────────────────────
        $testimonials = [
            ['author_name' => 'Sarah Mitchell', 'author_role' => 'Parent of Year 9 Student', 'content' => 'Greenfield Academy has been transformative for our daughter. The teachers genuinely care about every child\'s progress, and the school community is wonderfully supportive. She has grown so much in confidence and academic ability.', 'rating' => 5, 'is_featured' => true, 'order' => 1],
            ['author_name' => 'James Okafor', 'author_role' => 'Class of 2022 Alumnus', 'content' => 'My years at Greenfield Academy gave me the foundation I needed to succeed at university. The rigorous academics combined with incredible extra-curricular opportunities made me well-rounded and ready for the world.', 'rating' => 5, 'is_featured' => true, 'order' => 2],
            ['author_name' => 'Mr. & Mrs. Patel', 'author_role' => 'Parents of Two Students', 'content' => 'Both our children attend Greenfield and we couldn\'t be happier. The school strikes the perfect balance between academic excellence and personal development. Communication from staff is always prompt and helpful.', 'rating' => 5, 'is_featured' => true, 'order' => 3],
        ];
        foreach ($testimonials as $t) {
            \App\Models\Testimonial::create(array_merge($t, ['is_published' => true]));
        }

        $this->call([
            PageHeroSeeder::class,
            HomePageBlockSeeder::class,
            PageSectionSeeder::class,
            HomePageSectionSeeder::class,
        ]);
    }
}
