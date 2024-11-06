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

    //insert invoices attachments
    Route::post('/InvoiceAttachments', [InvoiceController::class, 'storeAttachment']);
    // show invoices attachments
    Route::get('/invoice-attachment/{invoiceNumber}/{fileName}', [InvoiceController::class, 'showAttachments']);
    // download Attachments
    Route::get('/download-invoice-attachment/{invoiceNumber}/{fileName}', [InvoiceController::class, 'downloadAttachments']);

    // delete invoice attachment
    Route::delete('/delete-invoice-attachment/{invoiceNumber}/{fileName}', [InvoiceController::class, 'deleteAttachments'])->name('attachments.destroy');

    // edit invoice status
    Route::get('/edit-invoice-status/{id}', [InvoiceController::class, 'getInvoiceStatus'])->name('invoices.get-status');

    // edit invoice status
    Route::put('/update-invoice-status/{id}', [InvoiceController::class, 'updateInvoiceStatus'])->name('invoices.update-status');

    //get invoice paied status
    Route::get('/invoice-paid', [InvoiceController::class, 'getInvoicePaid'])->name('invoices.paid');
    //get invoice unpaied status
    Route::get('/invoice-unpaid', [InvoiceController::class, 'getInvoiceUnpaid'])->name('invoices.unpaid');
    ///get invoice partial paid status
    Route::get('/invoice-partial', [InvoiceController::class, 'getInvoicePartial'])->name('invoices.partial');

    //create archive
    Route::delete('invoice-archive-store/{id}',[InvoiceController::class, 'storeInvoiceArchive'])->name('invoices.archive.store');
    Route::put('invoice-archive-restore/{id}',[InvoiceController::class, 'restoreInvoiceArchive'])->name('invoices.archive.restore');

    //invoice archive
    Route::get('/invoice-archive', [InvoiceController::class, 'getInvoiceArchive'])->name('invoices.archive');



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
