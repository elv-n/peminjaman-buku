<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Buku Tersedia</h2>
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
                
                <div class="row mb-4 justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <form action="{{ route('user.books.index') }}" method="GET">
                            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                                <span class="input-group-text bg-white border-0 ps-4">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-0 py-3 ps-2 shadow-none" placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <a href="{{ route('user.books.index') }}" class="btn bg-white border-0 text-muted">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                                <button class="btn btn-primary px-4 fw-bold" type="submit">Cari Koleksi</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="row g-4">
                    @forelse($books as $book)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                                <div class="position-relative">
                                    @if($book->cover)
                                        <div class="bg-light rounded-top-4 d-flex align-items-center justify-content-center" style="height: 280px;">
                                            <img src="{{ asset('storage/' . $book->cover) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $book->title }}" 
                                                 style="max-height: 280px; width: auto; max-width: 100%; object-fit: contain; cursor: pointer;"
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#previewModal{{ $book->id }}">
                                        </div>
                                    @else
                                        <div class="bg-light rounded-top-4 d-flex align-items-center justify-content-center" style="height: 280px;">
                                            <img src="{{ asset('images/no-cover.png') }}" 
                                                 class="card-img-top opacity-50" 
                                                 alt="No Cover" 
                                                 style="max-height: 150px; width: auto; object-fit: contain;">
                                        </div>
                                    @endif
                                    @if($book->stock > 0)
                                        <span class="badge bg-success position-absolute top-0 end-0 m-2">Tersedia: {{ $book->stock }}</span>
                                    @else
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Habis</span>
                                    @endif
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="card-title fw-bold text-dark mb-2" title="{{ $book->title }}">{{ $book->title }}</h6>
                                    
                                    <div class="d-flex align-items-center mb-1 text-muted small">
                                        <i class="bi bi-person me-2"></i>
                                        <span class="text-truncate">{{ $book->author }}</span>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-1 text-muted small">
                                        <i class="bi bi-building me-2"></i>
                                        <span class="text-truncate">{{ $book->publisher }}</span>
                                    </div>
                                    
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        <span>{{ $book->year }}</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 pt-0 pb-3">
                                    @if($book->stock > 0)
                                        <form action="{{ route('user.transactions.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm w-100 py-2 rounded-3" onclick="return confirm('Yakin ingin meminjam buku ini?');">
                                                Pinjam Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm w-100 py-2 rounded-3" disabled>Tidak Tersedia</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Modal Preview (Hanya jika ada cover) -->
                        @if($book->cover)
                        <div class="modal fade" id="previewModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 bg-transparent shadow-none">
                                    <div class="modal-body p-0 d-flex flex-column align-items-center position-relative">
                                        <div class="d-inline-block shadow-lg rounded-4 overflow-hidden position-relative">
                                            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2 shadow-none" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1051; scale: 0.8; filter: drop-shadow(0 0 2px rgba(0,0,0,0.5));"></button>
                                            <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid" style="max-height: 80vh;" alt="{{ $book->title }}">
                                        </div>
                                        
                                        <div class="mt-3 text-center text-white p-3 rounded-4 w-100" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
                                            <h4 class="fw-bold mb-1">{{ $book->title }}</h4>
                                            <p class="mb-0 opacity-75">{{ $book->author }} ({{ $book->year }})</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <p class="fs-4">Belum ada buku tersedia.</p>
                                <p>Silakan hubungi admin untuk update terbaru.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
