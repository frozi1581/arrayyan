@extends('layouts.app')

@section('title', 'Kelola Santri')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-graduate me-2"></i>Kelola Santri
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" id="searchInput" placeholder="Cari santri...">
        </div>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="groupFilter">
            <option value="">Semua Groups</option>
            @foreach($santris->pluck('groupMembers')->flatten()->pluck('group')->unique('id') as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
    </div>
</div>

<!-- Santris List -->
<div class="row" id="santrisList">
    @forelse($santris as $santri)
        <div class="col-md-6 col-lg-4 mb-4 santri-item" 
             data-name="{{ strtolower($santri->name) }}" 
             data-groups="{{ $santri->groupMembers->pluck('group.id')->implode(',') }}"
             data-status="{{ $santri->is_active ? 'active' : 'inactive' }}">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            @if($santri->profile_photo)
                                <img src="{{ Storage::url($santri->profile_photo) }}" 
                                     class="rounded-circle me-3" width="50" height="50" 
                                     style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="card-title mb-0">{{ $santri->name }}</h6>
                                <small class="text-muted">{{ $santri->email }}</small>
                            </div>
                        </div>
                        <span class="badge bg-{{ $santri->is_active ? 'success' : 'secondary' }}">
                            {{ $santri->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        @if($santri->phone)
                            <p class="text-muted mb-1">
                                <i class="fas fa-phone me-1"></i>{{ $santri->phone }}
                            </p>
                        @endif
                        
                        @if($santri->birth_date)
                            <p class="text-muted mb-1">
                                <i class="fas fa-birthday-cake me-1"></i>{{ $santri->birth_date->format('d M Y') }}
                            </p>
                        @endif
                        
                        @if($santri->gender)
                            <p class="text-muted mb-1">
                                <i class="fas fa-{{ $santri->gender === 'male' ? 'mars' : 'venus' }} me-1"></i>
                                {{ $santri->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        @endif
                    </div>
                    
                    <!-- Groups -->
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Groups:</h6>
                        @foreach($santri->groupMembers as $membership)
                            <span class="badge bg-primary me-1 mb-1">{{ $membership->group->name }}</span>
                        @endforeach
                    </div>
                    
                    <!-- Statistics -->
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="text-warning mb-0">{{ $santri->hafalans->count() }}</h6>
                                <small class="text-muted">Hafalan</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="text-success mb-0">{{ $santri->murajaahs->count() }}</h6>
                                <small class="text-muted">Murajaah</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h6 class="text-info mb-0">{{ $santri->hafalans->where('status', 'completed')->count() + $santri->murajaahs->where('status', 'completed')->count() }}</h6>
                            <small class="text-muted">Selesai</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('santris.show', $santri) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Lihat
                        </a>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('santris.edit', $santri) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('santris.destroy', $santri) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus santri ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-user-graduate fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada santri</h4>
                <p class="text-muted">Santri akan muncul di sini setelah bergabung dengan group yang Anda kelola.</p>
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
        $('.santri-item').each(function() {
            var santriName = $(this).data('name');
            if (santriName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Group filter
    $('#groupFilter').on('change', function() {
        var groupId = $(this).val();
        $('.santri-item').each(function() {
            var santriGroups = $(this).data('groups');
            if (groupId === '' || santriGroups.includes(groupId)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Status filter
    $('#statusFilter').on('change', function() {
        var status = $(this).val();
        $('.santri-item').each(function() {
            var santriStatus = $(this).data('status');
            if (status === '' || santriStatus === status) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection