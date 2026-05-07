<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Admin list all
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'book']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('book', function($bq) use ($search) {
                    $bq->where('title', 'like', "%{$search}%");
                })->orWhereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $transactions = $query->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        $users = \App\Models\User::where('role', 'user')->get();
        return view('admin.transactions.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $book = Book::find($request->book_id);
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        $book->decrement('stock');
        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'status' => 'required|in:borrowed,returned',
        ]);

        if ($transaction->status === 'borrowed' && $request->status === 'returned') {
            $transaction->book->increment('stock');
            if (empty($validated['return_date'])) {
                $validated['return_date'] = now()->toDateString();
            }
        } elseif ($transaction->status === 'pending' && $request->status === 'returned') {
            $transaction->book->increment('stock');
            if (empty($validated['return_date'])) {
                $validated['return_date'] = now()->toDateString();
            }
        } elseif ($transaction->status === 'returned' && $request->status === 'borrowed') {
            if ($transaction->book->stock < 1) {
                return back()->with('error', 'Stok buku habis.');
            }
            $transaction->book->decrement('stock');
            $validated['return_date'] = null;
        }

        $transaction->update($validated);
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->status === 'borrowed') {
            $transaction->book->increment('stock');
        }
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi dihapus.');
    }

    // USER LOGIC
    public function userIndex(Request $request)
    {
        $query = Transaction::with('book')
            ->where('user_id', auth()->id());

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $transactions = $query->get();
        return view('user.transactions.index', compact('transactions'));
    }

    public function storeUser(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $book = Book::find($request->book_id);
        
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        // Cek apakah user sedang meminjam buku yang sama
        $activeBorrow = Transaction::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($activeBorrow) {
            return back()->with('error', 'Anda masih meminjam buku ini.');
        }

        $book->decrement('stock');
        Transaction::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(), // Pinjam 7 hari
            'status' => 'borrowed'
        ]);

        return redirect()->route('user.transactions.index')->with('success', 'Buku berhasil dipinjam.');
    }

    public function returnBook(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id() || $transaction->status !== 'borrowed') {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        $transaction->update([
            'status' => 'pending',
            'return_date' => now()->toDateString()
        ]);

        return back()->with('success', 'Permintaan pengembalian dikirim. Menunggu konfirmasi admin.');
    }
}
