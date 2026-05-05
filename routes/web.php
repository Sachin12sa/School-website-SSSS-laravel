<?php

use App\Http\Controllers\admin\AdmissionController  as AdminAdmissionController;

// ── Public controllers ───────────────────────────────────────────────────────
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BlockController;
use App\Http\Controllers\admin\ContactController    as AdminContactController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\EventController      as AdminEventController;
use App\Http\Controllers\admin\FaqController        as AdminFaqController;
use App\Http\Controllers\admin\GalleryController    as AdminGalleryController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\MenuItemController;
use App\Http\Controllers\CalendarController;

// ── Admin controllers ────────────────────────────────────────────────────────
use App\Http\Controllers\admin\NewsController       as AdminNewsController;
use App\Http\Controllers\admin\PageSectionController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\TeacherController    as AdminTeacherController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\HeroController;
 

// Home
Route::get('/',         [HomeController::class, 'index'])->name('home');
Route::get('/healthz', [App\Http\Controllers\HealthController::class, 'show'])->name('healthz');

// About keeps its friendly route name while using the same dynamic controller.
Route::get('/about', [PageController::class, 'show'])->defaults('slug', 'about')->name('about');

// News
Route::get('/news',          [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}',   [NewsController::class, 'show'])->name('news.show');

// Events
Route::get('/events',          [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}',   [EventController::class, 'show'])->name('events.show');

// Gallery
Route::get('/gallery',       [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}',  [GalleryController::class, 'show'])->name('gallery.show')
     ->where('id', '[0-9]+');

// Faculty
Route::get('/faculty',   [TeacherController::class, 'index'])->name('teachers.index');

// FAQ
Route::get('/faq',       [FaqController::class, 'index'])->name('faq.index');
// Testimonials
Route::get('/testimonials', [TestimonialsController::class, 'index'])->name('testimonials.index');
// Calendar
Route::get('/calendar',     [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar/day', [CalendarController::class, 'day'])->name('calendar.day');

// Admissions
Route::get('/admissions',  [AdmissionController::class, 'index'])->name('admissions.index');
Route::post('/admissions', [AdmissionController::class, 'store'])->name('admissions.store');

// transport 
Route::get('/transportation',         [TransportController::class, 'index'])->name('transport.index');
Route::post('/transportation/report', [TransportController::class, 'report'])->name('transport.report');


// Contact
Route::get('/contact',  [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ── Dynamic CMS pages — MUST be last so it doesn't catch /news, /events etc ─
// The PageController checks for a dedicated template first, then falls back to generic.
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show')
     ->where('slug', '[a-z0-9\-]+');

// ════════════════════════════════════════════════════════════════════════════
// ADMIN AUTH (outside the middleware group — accessible when logged out)
// ════════════════════════════════════════════════════════════════════════════
Route::get('/admin/login',    [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',   [AuthController::class, 'login'])->name('admin.login.post');/*  */
Route::post('/admin/logout',  [AuthController::class, 'logout'])->name('admin.logout');

// ════════════════════════════════════════════════════════════════════════════
// ADMIN PANEL — protected by auth + admin middleware
// ════════════════════════════════════════════════════════════════════════════
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', 'admin'])
     ->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Settings (single form, multiple tabs) ──────────────────────────────
    Route::get('/settings',    [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings',   [SettingsController::class, 'update'])->name('settings.update');

    // ── Homepage Blocks ────────────────────────────────────────────────────
    Route::get('/blocks',              [BlockController::class, 'index'])->name('blocks.index');
    Route::put('/blocks/{id}',         [BlockController::class, 'update'])->name('blocks.update');
    Route::post('/blocks/reorder',     [BlockController::class, 'reorder'])->name('blocks.reorder');

    // ── Menus ──────────────────────────────────────────────────────────────
    Route::resource('menus', MenuController::class);
    Route::post('/menu-items',              [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::put('/menu-items/{menuItem}',    [MenuItemController::class, 'update'])->name('menu-items.update');
    Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');

    // ── News ───────────────────────────────────────────────────────────────
    Route::resource('news', AdminNewsController::class);

    // ── Events ─────────────────────────────────────────────────────────────
    Route::resource('events', AdminEventController::class);

    // ── Teachers (Faculty) ─────────────────────────────────────────────────
    Route::resource('teachers', AdminTeacherController::class);

    // ── Gallery ────────────────────────────────────────────────────────────
    Route::resource('gallery', AdminGalleryController::class);
    Route::post('/gallery/{gallery}/images',    [AdminGalleryController::class, 'uploadImages'])->name('gallery.images.upload');
    Route::delete('/gallery-images/{image}',    [AdminGalleryController::class, 'deleteImage'])->name('gallery.images.destroy');

    // ── Testimonials ───────────────────────────────────────────────────────
    Route::resource('testimonials', TestimonialController::class);

    // ── FAQs ───────────────────────────────────────────────────────────────
    Route::resource('faqs', AdminFaqController::class);

    // ── Admissions inbox ───────────────────────────────────────────────────
    Route::get('/admissions',                           [AdminAdmissionController::class, 'index'])->name('admissions.index');
    Route::get('/admissions/{admission}',               [AdminAdmissionController::class, 'show'])->name('admissions.show');
    Route::put('/admissions/{admission}/status',        [AdminAdmissionController::class, 'updateStatus'])->name('admissions.status');
    Route::delete('/admissions/{admission}',            [AdminAdmissionController::class, 'destroy'])->name('admissions.destroy');

    // ── Contact messages inbox ─────────────────────────────────────────────
    Route::get('/contacts',                   [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}',         [AdminContactController::class, 'show'])->name('contacts.show');
    Route::put('/contacts/{contact}/read',    [AdminContactController::class, 'markRead'])->name('contacts.read');
    Route::delete('/contacts/{contact}',      [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // ── Users (admin only) ─────────────────────────────────────────────────
    Route::resource('users', UserController::class);

    // ── Page Sections (dynamic page CMS) ──────────────────────────────────
    Route::get('/pages/{pageKey}/sections',              [PageSectionController::class, 'index'])->name('sections.index');
    Route::get('/pages/{pageKey}/sections/create',       [PageSectionController::class, 'create'])->name('sections.create');
    Route::post('/pages/{pageKey}/sections',             [PageSectionController::class, 'store'])->name('sections.store');
    Route::get('/pages/{pageKey}/sections/{section}/edit', [PageSectionController::class, 'edit'])->name('sections.edit');
    Route::put('/pages/{pageKey}/sections/{section}',    [PageSectionController::class, 'update'])->name('sections.update');
    Route::delete('/pages/{pageKey}/sections/{section}', [PageSectionController::class, 'destroy'])->name('sections.destroy');
    Route::post('/pages/{pageKey}/sections/{section}/toggle', [PageSectionController::class, 'toggle'])->name('sections.toggle');
    Route::post('/pages/{pageKey}/sections/reorder',     [PageSectionController::class, 'reorder'])->name('sections.reorder');
      // Hero management
    Route::get   ('heroes',                 [HeroController::class, 'index'])->name('heroes.index');
    Route::get   ('heroes/{hero}/edit',     [HeroController::class, 'edit'])->name('heroes.edit');
    Route::put   ('heroes/{hero}',          [HeroController::class, 'update'])->name('heroes.update');
    Route::delete('heroes/{hero}/image',    [HeroController::class, 'removeImage'])->name('heroes.remove-image');
});
