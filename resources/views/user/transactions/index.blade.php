<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Peminjaman Anda</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form action="{{ route('user.transactions.index') }}" method="GET">
                            <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-white border-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-0 py-2 shadow-none" placeholder="Cari judul buku..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <a href="{{ route('user.transactions.index') }}" class="btn bg-white border-0 text-muted">
                                        <i class="bi bi-x"></i>
                                    </a>
                                @endif
                                <button class="btn btn-primary px-4" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Tanggal Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $transaction->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->due_date)->format('d M Y') }}</td>
                            <td>
                                @if($transaction->status == 'borrowed')
                                    <span class="badge bg-warning">Sedang Dipinjam</span>
                                @elseif($transaction->status == 'pending')
                                    <span class="badge bg-info">Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td>{{ $transaction->return_date ? \Carbon\Carbon::parse($transaction->return_date)->format('d M Y') : '-' }}</td>
                            <td>
                                @if($transaction->status == 'borrowed')
                                    <form action="{{ route('user.transactions.return', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?');">
                                        @csrf @method('PUT')
                                        <button class="btn btn-sm btn-light text-primary bg-white border shadow-sm rounded-3 px-3 py-1" title="Kembalikan Buku">
                                            <i class="bi bi-arrow-return-left me-1"></i> <small>Kembalikan</small>
                                        </button>
                                    </form>
                                @elseif($transaction->status == 'pending')
                                    <span class="text-muted small">Sedang proses...</span>
                                @else
                                    <span class="text-success small fw-bold"><i class="bi bi-check-all"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Anda belum memiliki riwayat peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
