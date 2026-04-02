<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\PageController\BlockController;
// ─── Public Routes ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/faculty', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
Route::post('/admissions', [AdmissionController::class, 'store'])->name('admissions.store');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');

// ─── Admin Auth ────────────────────────────────────────────────────────────────
Route::get('/admin/login', [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');

// ─── Admin Panel ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');

    // Pages
    Route::resource('pages', Admin\PageController::class);

    // Homepage Blocks
    Route::get('/blocks', [Admin\BlockController::class, 'index'])->name('blocks.index');
    Route::put('/blocks/{id}', [Admin\BlockController::class, 'update'])->name('blocks.update');
    Route::post('/blocks/reorder', [Admin\BlockController::class, 'reorder'])->name('blocks.reorder');

    // Menus
    Route::resource('menus', Admin\MenuController::class);
    Route::resource('menu-items', Admin\MenuItemController::class);

    // News
    Route::resource('news', Admin\NewsController::class);

    // Events
    Route::resource('events', Admin\EventController::class);

    // Teachers
    Route::resource('teachers', Admin\TeacherController::class);

    // Gallery
    Route::resource('gallery', Admin\GalleryController::class);
    Route::post('/gallery/{gallery}/images', [Admin\GalleryController::class, 'uploadImages'])->name('gallery.images.upload');
    Route::delete('/gallery-images/{image}', [Admin\GalleryController::class, 'deleteImage'])->name('gallery.images.destroy');

    // Testimonials
    Route::resource('testimonials', Admin\TestimonialController::class);

    // FAQs
    Route::resource('faqs', Admin\FaqController::class);

    // Admissions
    Route::get('/admissions', [Admin\AdmissionController::class, 'index'])->name('admissions.index');
    Route::get('/admissions/{admission}', [Admin\AdmissionController::class, 'show'])->name('admissions.show');
    Route::put('/admissions/{admission}/status', [Admin\AdmissionController::class, 'updateStatus'])->name('admissions.status');
    Route::delete('/admissions/{admission}', [Admin\AdmissionController::class, 'destroy'])->name('admissions.destroy');

    // Contacts
    Route::get('/contacts', [Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::put('/contacts/{contact}/read', [Admin\ContactController::class, 'markRead'])->name('contacts.read');
    Route::delete('/contacts/{contact}', [Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    // Users
    Route::resource('users', Admin\UserController::class);
});