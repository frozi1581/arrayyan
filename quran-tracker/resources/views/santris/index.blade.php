@extends('layouts.app')

@section('title', 'Profil Santri')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-graduate me-2"></i>Profil Santri
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if($santri)
            <div class="btn-group me-2">
                <a href="{{ route('santris.edit', $santri) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>Edit Profil
                </a>
            </div>
        @else
            <div class="btn-group me-2">
                <a href="{{ route('santris.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Buat Profil Santri
                </a>
            </div>
        @endif
    </div>
</div>

@if($santri)
    <!-- Profile Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($santri->profile_photo)
                        <img src="{{ Storage::url($santri->profile_photo) }}" 
                             class="rounded-circle mb-3" width="120" height="120" 
                             style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    
                    <h5 class="card-title">{{ $santri->name }}</h5>
                    <p class="text-muted">{{ $santri->email }}</p>
                    
                    @if($santri->phone)
                        <p class="text-muted">
                            <i class="fas fa-phone me-1"></i>{{ $santri->phone }}
                        </p>
                    @endif
                    
                    @if($santri->birth_date)
                        <p class="text-muted">
                            <i class="fas fa-birthday-cake me-1"></i>{{ $santri->birth_date->format('d M Y') }}
                        </p>
                    @endif
                    
                    @if($santri->gender)
                        <p class="text-muted">
                            <i class="fas fa-{{ $santri->gender === 'male' ? 'mars' : 'venus' }} me-1"></i>
                            {{ $santri->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Informasi Lengkap
                    </h5>
                </div>
                <div class="card-body">
                    @if($santri->address)
                        <div class="mb-3">
                            <h6>Alamat</h6>
                            <p class="text-muted">{{ $santri->address }}</p>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Status</h6>
                                <span class="badge bg-{{ $santri->is_active ? 'success' : 'secondary' }}">
                                    {{ $santri->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Bergabung</h6>
                                <p class="text-muted">{{ $santri->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Groups Membership -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users text-info me-2"></i>Group Membership
                    </h5>
                </div>
                <div class="card-body">
                    @if($santri->groupMembers->count() > 0)
                        <div class="row">
                            @foreach($santri->groupMembers as $membership)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $membership->group->name }}</h6>
                                            <p class="card-text text-muted small">{{ $membership->group->description }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $membership->role === 'admin' ? 'primary' : 'secondary' }}">
                                                    {{ $membership->role === 'admin' ? 'Admin' : 'Member' }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $membership->joined_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum bergabung dengan group</h5>
                            <p class="text-muted">Bergabunglah dengan group untuk mulai mengelola hafalan dan murajaah.</p>
                            <a href="{{ route('groups.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Lihat Groups
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-book fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">{{ $santri->hafalans->count() }}</h5>
                    <p class="text-muted">Total Hafalan</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-redo fa-2x text-success mb-2"></i>
                    <h5 class="card-title">{{ $santri->murajaahs->count() }}</h5>
                    <p class="text-muted">Total Murajaah</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">{{ $santri->hafalans->where('status', 'completed')->count() + $santri->murajaahs->where('status', 'completed')->count() }}</h5>
                    <p class="text-muted">Tugas Selesai</p>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- No Profile -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-user-graduate fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada profil santri</h4>
                    <p class="text-muted">Buat profil santri untuk mulai menggunakan aplikasi Quran Tracker.</p>
                    <a href="{{ route('santris.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Buat Profil Santri
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection