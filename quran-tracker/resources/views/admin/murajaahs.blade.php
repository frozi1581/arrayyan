@extends('layouts.app')

@section('title', 'Review Murajaah')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-redo me-2"></i>Review Murajaah
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
            @foreach($murajaahs->pluck('group')->unique('id') as $group)
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

<!-- Murajaahs List -->
<div class="row" id="murajaahsList">
    @forelse($murajaahs as $murajaah)
        <div class="col-md-6 col-lg-4 mb-4 murajaah-item" 
             data-surah="{{ strtolower($murajaah->surah_name) }}" 
             data-status="{{ $murajaah->status }}"
             data-group="{{ $murajaah->group_id }}"
             data-date="{{ $murajaah->target_date->format('Y-m-d') }}">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title">{{ $murajaah->surah_name }}</h5>
                        <span class="badge bg-{{ $murajaah->status === 'completed' ? 'success' : ($murajaah->status === 'reviewed' ? 'info' : 'warning') }}">
                            {{ $murajaah->status === 'completed' ? 'Selesai' : ($murajaah->status === 'reviewed' ? 'Direview' : 'Pending') }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">
                            <i class="fas fa-user me-1"></i>{{ $murajaah->santri->name }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-users me-1"></i>{{ $murajaah->group->name }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-verse me-1"></i>Ayat {{ $murajaah->start_ayah }} - {{ $murajaah->end_ayah }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>{{ $murajaah->target_date->format('d M Y') }}
                        </p>
                    </div>
                    
                    @if($murajaah->notes)
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-sticky-note me-1"></i>{{ Str::limit($murajaah->notes, 50) }}
                            </small>
                        </div>
                    @endif
                    
                    @if($murajaah->completed_date)
                        <div class="mb-3">
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>Selesai: {{ $murajaah->completed_date->format('d M Y') }}
                            </small>
                        </div>
                    @endif
                    
                    @if($murajaah->score)
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2">Skor:</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" 
                                         style="width: {{ ($murajaah->score / 100) * 100 }}%"></div>
                                </div>
                                <span class="ms-2 text-success fw-bold">{{ $murajaah->score }}</span>
                            </div>
                        </div>
                    @endif
                    
                    @if($murajaah->feedback)
                        <div class="mb-3">
                            <small class="text-info">
                                <i class="fas fa-comment me-1"></i>{{ Str::limit($murajaah->feedback, 50) }}
                            </small>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-transparent">
                    @if($murajaah->status === 'completed')
                        <!-- Review Form -->
                        <form action="{{ route('admin.murajaahs.review', $murajaah) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" 
                                           name="score" placeholder="Skor (0-100)" min="0" max="100" required>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success btn-sm w-100">
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
                    @elseif($murajaah->status === 'reviewed')
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
                <i class="fas fa-redo fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada murajaah</h4>
                <p class="text-muted">Murajaah akan muncul di sini setelah santri menambahkan jadwal murajaah.</p>
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
        $('.murajaah-item').each(function() {
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
        $('.murajaah-item').each(function() {
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
        $('.murajaah-item').each(function() {
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
        
        $('.murajaah-item').each(function() {
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