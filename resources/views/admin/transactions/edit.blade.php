<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Transaksi (Update Status)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Peminjam</label>
                        <input type="text" class="form-control" value="{{ $transaction->user->name }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Buku</label>
                        <input type="text" class="form-control" value="{{ $transaction->book->title }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" value="{{ $transaction->borrow_date }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="borrowed" {{ $transaction->status == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="returned" {{ $transaction->status == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali (Otomatis terisi saat status Dikembalikan)</label>
                        <input type="date" name="return_date" class="form-control" value="{{ old('return_date', $transaction->return_date) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
