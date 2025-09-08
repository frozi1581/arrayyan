@extends('layouts.app')

@section('title', 'Review Hafalan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-book me-2"></i>Review Hafalan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="row mb-4">
    <div class="col-md-4">
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
        <select class="form-select" id="groupFilter">
            <option value="">Semua Groups</option>
            @foreach($hafalans->pluck('group')->unique('id') as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
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
             data-group="{{ $hafalan->group_id }}"
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
                            <i class="fas fa-user me-1"></i>{{ $hafalan->santri->name }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-users me-1"></i>{{ $hafalan->group->name }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-verse me-1"></i>Ayat {{ $hafalan->start_ayah }} - {{ $hafalan->end_ayah }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>{{ $hafalan->target_date->format('d M Y') }}
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
                    
                    @if($hafalan->feedback)
                        <div class="mb-3">
                            <small class="text-info">
                                <i class="fas fa-comment me-1"></i>{{ Str::limit($hafalan->feedback, 50) }}
                            </small>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-transparent">
                    @if($hafalan->status === 'completed')
                        <!-- Review Form -->
                        <form action="{{ route('admin.hafalans.review', $hafalan) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" 
                                           name="score" placeholder="Skor (0-100)" min="0" max="100" required>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-star me-1"></i>Review
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <textarea class="form-control form-control-sm" 
                                          name="feedback" rows="2" 
                                          placeholder="Feedback untuk santri..."></textarea>
                            </div>
                        </form>
                    @elseif($hafalan->status === 'reviewed')
                        <div class="text-center">
                            <span class="badge bg-info">
                                <i class="fas fa-check me-1"></i>Sudah Direview
                            </span>
                        </div>
                    @else
                        <div class="text-center">
                            <span class="badge bg-warning">
                                <i class="fas fa-clock me-1"></i>Menunggu Penyelesaian
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada hafalan</h4>
                <p class="text-muted">Hafalan akan muncul di sini setelah santri menambahkan target hafalan.</p>
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
    
    // Group filter
    $('#groupFilter').on('change', function() {
        var groupId = $(this).val();
        $('.hafalan-item').each(function() {
            var itemGroup = $(this).data('group');
            if (groupId === '' || itemGroup == groupId) {
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