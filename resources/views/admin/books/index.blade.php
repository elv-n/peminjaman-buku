<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Buku') }}
        </h2>
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
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Buku
                    </a>

                    <form action="{{ route('admin.books.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari judul, penulis..." value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary border-start-0">
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
                            <th>Sampul</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" 
                                         alt="Cover" 
                                         width="50" 
                                         class="img-thumbnail shadow-sm cursor-pointer"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#previewModal{{ $book->id }}"
                                         style="cursor: pointer;">
                                    
                                    <!-- Modal Preview -->
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
                                                        <p class="mb-0 opacity-75">{{ $book->author }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ asset('images/no-cover.png') }}" alt="No Cover" width="50" class="img-thumbnail opacity-75">
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher }}</td>
                            <td class="text-center">{{ $book->year }}</td>
                            <td class="text-center">{{ $book->stock }}</td>
                            <td class="text-nowrap">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-light text-warning bg-white border shadow-sm rounded-3 px-2 py-1" title="Edit">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger bg-white border shadow-sm rounded-3 px-2 py-1" title="Hapus">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data buku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
