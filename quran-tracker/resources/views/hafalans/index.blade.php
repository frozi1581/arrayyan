@extends('layouts.app')

@section('title', 'Hafalan Baru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-book me-2"></i>Hafalan Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('hafalans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah Hafalan
            </a>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" id="searchInput" placeholder="Cari surah...">
        </div>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="completed">Selesai</option>
            <option value="reviewed">Direview</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="dateFilter">
            <option value="">Semua Tanggal</option>
            <option value="today">Hari Ini</option>
            <option value="week">Minggu Ini</option>
            <option value="month">Bulan Ini</option>
        </select>
    </div>
</div>

<!-- Hafalans List -->
<div class="row" id="hafalansList">
    @forelse($hafalans as $hafalan)
        <div class="col-md-6 col-lg-4 mb-4 hafalan-item" 
             data-surah="{{ strtolower($hafalan->surah_name) }}" 
             data-status="{{ $hafalan->status }}"
             data-date="{{ $hafalan->target_date->format('Y-m-d') }}">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title">{{ $hafalan->surah_name }}</h5>
                        <span class="badge bg-{{ $hafalan->status === 'completed' ? 'success' : ($hafalan->status === 'reviewed' ? 'info' : 'warning') }}">
                            {{ $hafalan->status === 'completed' ? 'Selesai' : ($hafalan->status === 'reviewed' ? 'Direview' : 'Pending') }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">
                            <i class="fas fa-verse me-1"></i>Ayat {{ $hafalan->start_ayah }} - {{ $hafalan->end_ayah }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>{{ $hafalan->target_date->format('d M Y') }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fas fa-users me-1"></i>{{ $hafalan->group->name }}
                        </p>
                    </div>
                    
                    @if($hafalan->notes)
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-sticky-note me-1"></i>{{ Str::limit($hafalan->notes, 50) }}
                            </small>
                        </div>
                    @endif
                    
                    @if($hafalan->completed_date)
                        <div class="mb-3">
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>Selesai: {{ $hafalan->completed_date->format('d M Y') }}
                            </small>
                        </div>
                    @endif
                    
                    @if($hafalan->score)
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2">Skor:</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-primary" 
                                         style="width: {{ ($hafalan->score / 100) * 100 }}%"></div>
                                </div>
                                <span class="ms-2 text-primary fw-bold">{{ $hafalan->score }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('hafalans.show', $hafalan) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('hafalans.edit', $hafalan) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('hafalans.destroy', $hafalan) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus hafalan ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        
                        @if($hafalan->status === 'pending')
                            <form action="{{ route('hafalans.complete', $hafalan) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check me-1"></i>Selesai
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada hafalan</h4>
                <p class="text-muted">Tambahkan hafalan baru untuk mulai melacak progress Anda.</p>
                <a href="{{ route('hafalans.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Hafalan Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('.hafalan-item').each(function() {
            var surahName = $(this).data('surah');
            if (surahName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Status filter
    $('#statusFilter').on('change', function() {
        var status = $(this).val();
        $('.hafalan-item').each(function() {
            var itemStatus = $(this).data('status');
            if (status === '' || itemStatus === status) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Date filter
    $('#dateFilter').on('change', function() {
        var filter = $(this).val();
        var today = new Date();
        
        $('.hafalan-item').each(function() {
            var itemDate = new Date($(this).data('date'));
            var show = true;
            
            switch(filter) {
                case 'today':
                    show = itemDate.toDateString() === today.toDateString();
                    break;
                case 'week':
                    var weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());
                    var weekEnd = new Date(weekStart);
                    weekEnd.setDate(weekStart.getDate() + 6);
                    show = itemDate >= weekStart && itemDate <= weekEnd;
                    break;
                case 'month':
                    show = itemDate.getMonth() === today.getMonth() && 
                           itemDate.getFullYear() === today.getFullYear();
                    break;
            }
            
            if (show) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection