@extends('layouts.app')

@section('title', 'Groups')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2"></i>Groups
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('groups.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Buat Group Baru
            </a>
        </div>
    </div>
</div>

<!-- Join Group Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-sign-in-alt text-info me-2"></i>Bergabung dengan Group
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('groups.join', ['group' => 1]) }}" class="row g-3">
                    @csrf
                    <div class="col-md-8">
                        <label for="code" class="form-label">Kode Group</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                               id="code" name="code" placeholder="Masukkan kode group" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-sign-in-alt me-1"></i>Bergabung
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Groups List -->
<div class="row">
    @forelse($groups as $group)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title">{{ $group->name }}</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('groups.show', $group) }}">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('groups.edit', $group) }}">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('groups.destroy', $group) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus group ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <p class="card-text text-muted">{{ $group->description ?: 'Tidak ada deskripsi' }}</p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="text-primary mb-0">{{ $group->members->count() }}</h6>
                                <small class="text-muted">Anggota</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="text-warning mb-0">{{ $group->hafalans->count() }}</h6>
                                <small class="text-muted">Hafalan</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h6 class="text-success mb-0">{{ $group->murajaahs->count() }}</h6>
                            <small class="text-muted">Murajaah</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-key me-1"></i>Kode: <strong>{{ $group->code }}</strong>
                        </small>
                        <span class="badge bg-{{ $group->is_active ? 'success' : 'secondary' }}">
                            {{ $group->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('groups.show', $group) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye me-1"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada group</h4>
                <p class="text-muted">Buat group pertama Anda untuk memulai mengelola hafalan dan murajaah.</p>
                <a href="{{ route('groups.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Buat Group Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

@endsection