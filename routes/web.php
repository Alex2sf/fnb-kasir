<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\PosController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\CustomerController;
use App\Http\Controllers\Owner\TransactionController;
use App\Http\Controllers\Owner\OnboardingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('/panduan', 'guide')->name('guide');

// Central redirect after login
Route::get('/dashboard', function () {
    $role = auth()->user()->role->name;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('owner.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Owner\ArticleController as OwnerArticleController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::post('/users/{user}/toggle-status', [AdminDashboard::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('articles', AdminArticleController::class);
});

// Owner Routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    // Onboarding (new store setup)
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');
    Route::get('/pos', [PosController::class, 'index'])->name('pos');
    
    // Management
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class)->except(['create', 'show', 'edit']);
    
    // Transactions
    Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/print', [TransactionController::class, 'print'])->name('transactions.print');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    // Fitur Baru (Opsional)
    Route::resource('tables', \App\Http\Controllers\Owner\TableController::class)->except(['show']);
    Route::resource('discounts', \App\Http\Controllers\Owner\DiscountController::class)->except(['show']);
    Route::resource('expenses', \App\Http\Controllers\Owner\ExpenseController::class)->except(['show']);
    
    // Edukasi
    Route::get('/articles', [OwnerArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article:slug}', [OwnerArticleController::class, 'show'])->name('articles.show');
});

require __DIR__.'/auth.php';
