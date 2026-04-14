<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CarouselSlideController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::post('products/upload-image', [ProductController::class, 'uploadImage'])->name('products.upload-image');
    Route::post('products/test-update', [ProductController::class, 'testUpdate'])->name('products.test-update');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    
    // Users
    Route::resource('users', UserController::class);
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
    Route::get('orders/export/csv', [OrderController::class, 'exportCsv'])->name('orders.export-csv');
    
    // FAQs
    Route::resource('faqs', FaqController::class);
    Route::patch('faqs/{faq}/toggle-status', [FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');
    
    // Contact Messages
    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::patch('contact-messages/{contactMessage}/status', [ContactMessageController::class, 'updateStatus'])->name('contact-messages.update-status');
    Route::patch('contact-messages/{contactMessage}/notes', [ContactMessageController::class, 'updateNotes'])->name('contact-messages.update-notes');
    Route::post('contact-messages/mark-all-read', [ContactMessageController::class, 'markAllAsRead'])->name('contact-messages.mark-all-read');
    
    // Carousel Slides
    Route::resource('carousel-slides', CarouselSlideController::class);
    Route::patch('carousel-slides/{carouselSlide}/toggle-status', [CarouselSlideController::class, 'toggleStatus'])->name('carousel-slides.toggle-status');
    Route::post('carousel-slides/reorder', [CarouselSlideController::class, 'updateOrder'])->name('carousel-slides.reorder');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/contact', [SettingController::class, 'contact'])->name('settings.contact');
    Route::get('settings/social', [SettingController::class, 'social'])->name('settings.social');
}); 