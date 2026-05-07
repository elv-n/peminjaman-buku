<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna</h2>
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

                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-auto">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bi bi-plus-lg me-2"></i> Tambah Pengguna
                        </a>
                    </div>
                    <div class="col-md">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2">
                            @if(request('role'))
                                <input type="hidden" name="role" value="{{ request('role') }}">
                            @endif
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <a href="{{ route('admin.users.index', request()->only('role')) }}" class="btn btn-outline-secondary border-start-0">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                                <button class="btn btn-primary px-4" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-auto">
                        <ul class="nav nav-pills bg-light p-1 rounded-3">
                            <li class="nav-item">
                                <a class="nav-link {{ !request('role') ? 'active px-4' : 'text-muted' }}" href="{{ route('admin.users.index', request()->only('search')) }}">Semua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('role') == 'admin' ? 'active px-4' : 'text-muted' }}" href="{{ route('admin.users.index', array_merge(request()->only('search'), ['role' => 'admin'])) }}">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('role') == 'user' ? 'active px-4' : 'text-muted' }}" href="{{ route('admin.users.index', array_merge(request()->only('search'), ['role' => 'user'])) }}">Anggota</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center"><span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">{{ ucfirst($user->role) }}</span></td>
                            <td class="text-nowrap">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light text-warning bg-white border shadow-sm rounded-3 px-2 py-1" title="Edit">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
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
