<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Transaksi Peminjaman</h2>
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Transaksi
                    </a>

                    <form action="{{ route('admin.transactions.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari peminjam, buku..." value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary border-start-0">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                            <button class="btn btn-primary px-4" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                
                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->book->title }}</td>
                            <td class="text-center">{{ $transaction->borrow_date }}</td>
                            <td class="text-center">{{ $transaction->due_date }}</td>
                            <td class="text-center">{{ $transaction->return_date ?? '-' }}</td>
                            <td>
                                @if($transaction->status == 'borrowed')
                                    <span class="badge bg-warning">Dipinjam</span>
                                @elseif($transaction->status == 'pending')
                                    <span class="badge bg-info">Menunggu Persetujuan</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <div class="d-flex gap-2">
                                    @if($transaction->status == 'pending')
                                        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="returned">
                                            <button type="submit" class="btn btn-sm btn-light text-success bg-white border shadow-sm rounded-3 px-2 py-1" title="Konfirmasi Kembali">
                                                <i class="bi bi-check-circle fs-6"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-sm btn-light text-warning bg-white border shadow-sm rounded-3 px-2 py-1" title="Edit">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </a>
                                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger bg-white border shadow-sm rounded-3 px-2 py-1" title="Hapus">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
