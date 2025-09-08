@extends('layouts.app')

@section('title', 'Murajaah')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-redo me-2"></i>Murajaah
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('murajaahs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah Murajaah
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

<!-- Murajaahs List -->
<div class="row" id="murajaahsList">
    @forelse($murajaahs as $murajaah)
        <div class="col-md-6 col-lg-4 mb-4 murajaah-item" 
             data-surah="{{ strtolower($murajaah->surah_name) }}" 
             data-status="{{ $murajaah->status }}"
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
                            <i class="fas fa-verse me-1"></i>Ayat {{ $murajaah->start_ayah }} - {{ $murajaah->end_ayah }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>{{ $murajaah->target_date->format('d M Y') }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fas fa-users me-1"></i>{{ $murajaah->group->name }}
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
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('murajaahs.show', $murajaah) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('murajaahs.edit', $murajaah) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('murajaahs.destroy', $murajaah) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus murajaah ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        
                        @if($murajaah->status === 'pending')
                            <form action="{{ route('murajaahs.complete', $murajaah) }}" method="POST" class="d-inline">
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
                <i class="fas fa-redo fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada murajaah</h4>
                <p class="text-muted">Tambahkan murajaah untuk mengulang hafalan yang sudah dipelajari.</p>
                <a href="{{ route('murajaahs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Murajaah Pertama
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