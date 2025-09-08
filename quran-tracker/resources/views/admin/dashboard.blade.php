@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar me-1"></i>{{ now()->format('d M Y') }}
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h5 class="card-title">{{ $totalGroups }}</h5>
                <p class="text-muted">Total Groups</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-user-graduate fa-2x text-success mb-2"></i>
                <h5 class="card-title">{{ $totalSantris }}</h5>
                <p class="text-muted">Total Santri</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-book fa-2x text-warning mb-2"></i>
                <h5 class="card-title">{{ $totalHafalans }}</h5>
                <p class="text-muted">Total Hafalan</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-redo fa-2x text-info mb-2"></i>
                <h5 class="card-title">{{ $totalMurajaahs }}</h5>
                <p class="text-muted">Total Murajaah</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt text-info me-2"></i>Aksi Cepat Admin
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.santris') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-user-graduate me-2"></i>Kelola Santri
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.hafalans') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-book me-2"></i>Review Hafalan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.murajaahs') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-redo me-2"></i>Review Murajaah
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('groups.index') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-users me-2"></i>Kelola Groups
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <!-- Recent Hafalans -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book text-warning me-2"></i>Hafalan Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recentHafalans->count() > 0)
                    @foreach($recentHafalans as $hafalan)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                            <div>
                                <h6 class="mb-1">{{ $hafalan->surah_name }}</h6>
                                <small class="text-muted">
                                    {{ $hafalan->santri->name }} - {{ $hafalan->group->name }}
                                </small>
                            </div>
                            <div>
                                <span class="badge bg-{{ $hafalan->status === 'completed' ? 'success' : ($hafalan->status === 'reviewed' ? 'info' : 'warning') }}">
                                    {{ $hafalan->status === 'completed' ? 'Selesai' : ($hafalan->status === 'reviewed' ? 'Direview' : 'Pending') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-book fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Belum ada hafalan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Murajaahs -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-redo text-success me-2"></i>Murajaah Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recentMurajaahs->count() > 0)
                    @foreach($recentMurajaahs as $murajaah)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                            <div>
                                <h6 class="mb-1">{{ $murajaah->surah_name }}</h6>
                                <small class="text-muted">
                                    {{ $murajaah->santri->name }} - {{ $murajaah->group->name }}
                                </small>
                            </div>
                            <div>
                                <span class="badge bg-{{ $murajaah->status === 'completed' ? 'success' : ($murajaah->status === 'reviewed' ? 'info' : 'warning') }}">
                                    {{ $murajaah->status === 'completed' ? 'Selesai' : ($murajaah->status === 'reviewed' ? 'Direview' : 'Pending') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-redo fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Belum ada murajaah</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Groups Overview -->
@if($groups->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users text-primary me-2"></i>Groups yang Dikelola
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($groups as $group)
                        <div class="col-md-4 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $group->name }}</h6>
                                    <p class="card-text text-muted small">{{ $group->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-users me-1"></i>{{ $group->members->count() }} anggota
                                        </small>
                                        <a href="{{ route('groups.show', $group) }}" class="btn btn-sm btn-outline-primary">
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection