<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Invoice get product Routes
    Route::get('/invoices/get-products/{sectionId}', [InvoiceController::class, 'getProducts'])->name('invoices.get-products');

    // show invoices attachments
    Route::get('/invoice-attachment/{invoiceNumber}/{fileName}', [InvoiceController::class, 'showAttachments']);
    // download Attachments
    Route::get('/download-invoice-attachment/{invoiceNumber}/{fileName}', [InvoiceController::class, 'downloadAttachments']);

    // delete invoice attachment
    Route::delete('/delete-invoice-attachment/{invoiceNumber}/{fileName}', [InvoiceController::class, 'deleteAttachments'])->name('attachments.destroy');

    // Resource Routes
    Route::resources([
        // invoices routes
        'invoices' => InvoiceController::class,
        // sections routes
        'sections' => SectionController::class,
        // products routes
        'products' => ProductController::class,
    ]);

});

// Admin Routes

require __DIR__ . '/auth.php';
Route::get('/{id}', [AdminController::class, 'index']);
