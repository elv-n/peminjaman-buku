<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $stats = [
        'total_books' => \App\Models\Book::count(), // Tetap tampilkan total koleksi perpus
        'total_members' => \App\Models\User::where('role', 'user')->count(),
        'total_transactions' => \App\Models\Transaction::count(),
        'borrowed_count' => \App\Models\Transaction::where('status', 'borrowed')->count(),
        'pending_count' => \App\Models\Transaction::where('status', 'pending')->count(),
        'returned_count' => \App\Models\Transaction::where('status', 'returned')->count(),
        
        // Stats khusus user
        'user_total' => \App\Models\Transaction::where('user_id', $user->id)->count(),
        'user_borrowed' => \App\Models\Transaction::where('user_id', $user->id)->where('status', 'borrowed')->count(),
        'user_pending' => \App\Models\Transaction::where('user_id', $user->id)->where('status', 'pending')->count(),
        'user_returned' => \App\Models\Transaction::where('user_id', $user->id)->where('status', 'returned')->count(),
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class);
    Route::resource('transactions', TransactionController::class);
});

// User Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('books', [BookController::class, 'userIndex'])->name('books.index');
    Route::post('transactions', [TransactionController::class, 'storeUser'])->name('transactions.store');
    Route::put('transactions/{transaction}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
    Route::get('transactions', [TransactionController::class, 'userIndex'])->name('transactions.index');
});

require __DIR__.'/auth.php';
