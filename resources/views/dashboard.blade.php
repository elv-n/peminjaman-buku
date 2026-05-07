<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold text-dark mb-4">Selamat Datang, {{ Auth::user()->name }}</h2>
                    
                    @if(Auth::user()->role == 'admin')
                        <div class="row g-4 mb-5">
                            @php
                                $stats_items = [
                                    ['label' => 'Total Buku', 'value' => $stats['total_books'], 'icon' => 'bi-book', 'bg' => 'bg-primary'],
                                    ['label' => 'Anggota', 'value' => $stats['total_members'], 'icon' => 'bi-people', 'bg' => 'bg-success'],
                                    ['label' => 'Dipinjam', 'value' => $stats['borrowed_count'], 'icon' => 'bi-arrow-repeat', 'bg' => 'bg-warning'],
                                    ['label' => 'Pending', 'value' => $stats['pending_count'], 'icon' => 'bi-clock-history', 'bg' => 'bg-info'],
                                    ['label' => 'Kembali', 'value' => $stats['returned_count'], 'icon' => 'bi-check-circle', 'bg' => 'bg-success'],
                                ];
                            @endphp

                            @foreach($stats_items as $item)
                            <div class="col-6 col-md-4 col-lg">
                                <div class="card border-0 shadow-sm {{ $item['bg'] }} text-white h-100 position-relative overflow-hidden rounded-4">
                                    <div class="card-body p-4 position-relative" style="z-index: 2;">
                                        <h6 class="text-uppercase x-small fw-bold opacity-75 mb-1">{{ $item['label'] }}</h6>
                                        <h1 class="display-5 fw-bold mb-0">{{ $item['value'] }}</h1>
                                    </div>
                                    <i class="bi {{ $item['icon'] }} position-absolute" style="bottom: -10px; right: 5px; font-size: 3.5rem; opacity: 0.2; z-index: 1;"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <a href="{{ route('admin.books.index') }}" class="text-decoration-none">
                                    <div class="card border shadow-none rounded-4 p-4 h-100 transition-all hover-translate-y bg-light-hover text-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-collection fs-3"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Data Buku</h5>
                                        <p class="text-muted small mb-0">Kelola koleksi buku & stok.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">
                                    <div class="card border shadow-none rounded-4 p-4 h-100 transition-all hover-translate-y bg-light-hover text-center">
                                        <div class="rounded-circle bg-dark bg-opacity-10 p-3 text-dark mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-journal-check fs-3"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Data Transaksi</h5>
                                        <p class="text-muted small mb-0">Verifikasi peminjaman buku.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                                    <div class="card border shadow-none rounded-4 p-4 h-100 transition-all hover-translate-y bg-light-hover text-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-people fs-3"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Data Pengguna</h5>
                                        <p class="text-muted small mb-0">Kelola informasi pengguna.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row g-4 mb-5">
                            @php
                                $user_stats = [
                                    ['label' => 'Total Pinjaman', 'value' => $stats['user_total'], 'icon' => 'bi-journal-album', 'bg' => 'bg-primary'],
                                    ['label' => 'Sedang Dipinjam', 'value' => $stats['user_borrowed'], 'icon' => 'bi-arrow-repeat', 'bg' => 'bg-warning'],
                                    ['label' => 'Pending', 'value' => $stats['user_pending'], 'icon' => 'bi-clock-history', 'bg' => 'bg-info'],
                                    ['label' => 'Sudah Kembali', 'value' => $stats['user_returned'], 'icon' => 'bi-check-circle', 'bg' => 'bg-success'],
                                ];
                            @endphp

                            @foreach($user_stats as $item)
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm {{ $item['bg'] }} text-white h-100 position-relative overflow-hidden rounded-4">
                                    <div class="card-body p-4 position-relative" style="z-index: 2;">
                                        <h6 class="text-uppercase x-small fw-bold opacity-75 mb-1">{{ $item['label'] }}</h6>
                                        <h1 class="display-5 fw-bold mb-0">{{ $item['value'] }}</h1>
                                    </div>
                                    <i class="bi {{ $item['icon'] }} position-absolute" style="bottom: -10px; right: 5px; font-size: 3.5rem; opacity: 0.2; z-index: 1;"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <a href="{{ route('user.books.index') }}" class="text-decoration-none text-dark">
                                    <div class="card border shadow-none rounded-4 p-4 h-100 transition-all hover-translate-y bg-light-hover text-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-search fs-3"></i>
                                        </div>
                                        <h4 class="fw-bold mb-1">Jelajahi Koleksi</h4>
                                        <p class="text-muted small mb-0">Temukan buku favorit Anda.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('user.transactions.index') }}" class="text-decoration-none text-dark">
                                    <div class="card border shadow-none rounded-4 p-4 h-100 transition-all hover-translate-y bg-light-hover text-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-clock-history fs-3"></i>
                                        </div>
                                        <h4 class="fw-bold mb-1">Peminjaman Saya</h4>
                                        <p class="text-muted small mb-0">Lihat status buku Anda.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-translate-y { transition: transform 0.3s; }
        .hover-translate-y:hover { transform: translateY(-5px); }
        .bg-light-hover:hover { background-color: #f8f9fa; }
        .x-small { font-size: 0.75rem; }
    </style>
</x-app-layout>
