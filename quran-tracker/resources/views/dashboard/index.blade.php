@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar me-1"></i>{{ now()->format('d M Y') }}
            </button>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="card-title mb-2">
                            <i class="fas fa-sun me-2"></i>Assalamu'alaikum, {{ Auth::user()->name }}!
                        </h3>
                        <p class="card-text mb-0">
                            Selamat datang di Quran Tracker. Mari kita tingkatkan hafalan dan murajaah kita hari ini.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <i class="fas fa-book-quran fa-4x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Cards -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-book text-primary me-2"></i>Hafalan Baru
                    </h5>
                    <span class="badge bg-primary">{{ $weeklyHafalans->count() }} tugas</span>
                </div>
                <div class="progress mb-3" style="height: 20px;">
                    <div class="progress-bar bg-primary" role="progressbar" 
                         style="width: {{ $hafalanProgress }}%" 
                         aria-valuenow="{{ $hafalanProgress }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        {{ number_format($hafalanProgress, 1) }}%
                    </div>
                </div>
                <p class="text-muted mb-0">
                    {{ $weeklyHafalans->where('status', 'completed')->count() }} dari {{ $weeklyHafalans->count() }} selesai
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-redo text-success me-2"></i>Murajaah
                    </h5>
                    <span class="badge bg-success">{{ $weeklyMurajaahs->count() }} tugas</span>
                </div>
                <div class="progress mb-3" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: {{ $murajaahProgress }}%" 
                         aria-valuenow="{{ $murajaahProgress }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        {{ number_format($murajaahProgress, 1) }}%
                    </div>
                </div>
                <p class="text-muted mb-0">
                    {{ $weeklyMurajaahs->where('status', 'completed')->count() }} dari {{ $weeklyMurajaahs->count() }} selesai
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Today's Tasks -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-day text-warning me-2"></i>Tugas Hari Ini
                </h5>
            </div>
            <div class="card-body">
                @if($todayHafalans->count() > 0 || $todayMurajaahs->count() > 0)
                    <div class="row">
                        <!-- Hafalan Tasks -->
                        @if($todayHafalans->count() > 0)
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-book me-2"></i>Hafalan Baru
                                </h6>
                                @foreach($todayHafalans as $hafalan)
                                    <div class="task-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $hafalan->surah_name }}</h6>
                                                <p class="text-muted mb-1">Ayat {{ $hafalan->start_ayah }} - {{ $hafalan->end_ayah }}</p>
                                                <small class="text-muted">{{ $hafalan->group->name }}</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning">Pending</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Murajaah Tasks -->
                        @if($todayMurajaahs->count() > 0)
                            <div class="col-md-6">
                                <h6 class="text-success mb-3">
                                    <i class="fas fa-redo me-2"></i>Murajaah
                                </h6>
                                @foreach($todayMurajaahs as $murajaah)
                                    <div class="task-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $murajaah->surah_name }}</h6>
                                                <p class="text-muted mb-1">Ayat {{ $murajaah->start_ayah }} - {{ $murajaah->end_ayah }}</p>
                                                <small class="text-muted">{{ $murajaah->group->name }}</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning">Pending</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-muted">Tidak ada tugas untuk hari ini</h5>
                        <p class="text-muted">Selamat! Semua tugas hari ini sudah selesai.</p>
                    </div>
                @endif
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
                    <i class="fas fa-bolt text-info me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('groups.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>Buat Group
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('santris.create') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-user-plus me-2"></i>Tambah Santri
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('hafalans.create') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-book me-2"></i>Tambah Hafalan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('murajaahs.create') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-redo me-2"></i>Tambah Murajaah
                        </a>
                    </div>
                </div>
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
                    <i class="fas fa-users text-primary me-2"></i>Groups Saya
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

@section('scripts')
<script>
    // Auto refresh dashboard every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
</script>
@endsection