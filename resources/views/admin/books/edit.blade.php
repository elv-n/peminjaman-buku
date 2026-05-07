<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Buku</h2>
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

                <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penulis</label>
                                <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $book->publisher) }}" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input type="number" name="year" class="form-control" value="{{ old('year', $book->year) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Sampul Saat Ini</label>
                                <div class="mb-2">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="img-thumbnail" style="max-height: 200px;">
                                    @else
                                        <img src="{{ asset('images/no-cover.png') }}" alt="No Cover" class="img-thumbnail opacity-50" style="max-height: 200px;">
                                    @endif
                                </div>
                                <label class="form-label text-primary">Ganti Sampul</label>
                                <input type="file" name="cover" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock) }}" min="0" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
