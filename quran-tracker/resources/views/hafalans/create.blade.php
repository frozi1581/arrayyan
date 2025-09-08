@extends('layouts.app')

@section('title', 'Tambah Hafalan Baru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus me-2"></i>Tambah Hafalan Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('hafalans.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book text-primary me-2"></i>Informasi Hafalan Baru
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('hafalans.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="group_id" class="form-label">Group <span class="text-danger">*</span></label>
                        <select class="form-select @error('group_id') is-invalid @enderror" 
                                id="group_id" name="group_id" required>
                            <option value="">Pilih Group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="surah_name" class="form-label">Nama Surah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('surah_name') is-invalid @enderror" 
                               id="surah_name" name="surah_name" value="{{ old('surah_name') }}" 
                               placeholder="Masukkan nama surah" required>
                        @error('surah_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_ayah" class="form-label">Ayat Mulai <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('start_ayah') is-invalid @enderror" 
                                       id="start_ayah" name="start_ayah" value="{{ old('start_ayah') }}" 
                                       min="1" placeholder="1" required>
                                @error('start_ayah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_ayah" class="form-label">Ayat Selesai <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('end_ayah') is-invalid @enderror" 
                                       id="end_ayah" name="end_ayah" value="{{ old('end_ayah') }}" 
                                       min="1" placeholder="5" required>
                                @error('end_ayah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="target_date" class="form-label">Target Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('target_date') is-invalid @enderror" 
                               id="target_date" name="target_date" value="{{ old('target_date', date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" required>
                        @error('target_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="Tambahkan catatan atau instruksi khusus">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tips:</strong> 
                        <ul class="mb-0 mt-2">
                            <li>Pilih target tanggal yang realistis untuk menghafal</li>
                            <li>Mulai dengan ayat yang sedikit terlebih dahulu</li>
                            <li>Gunakan catatan untuk mencatat poin penting atau kesulitan</li>
                        </ul>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('hafalans.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Hafalan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-calculate end_ayah when start_ayah changes
    $('#start_ayah').on('change', function() {
        var startAyah = parseInt($(this).val());
        var endAyah = parseInt($('#end_ayah').val());
        
        if (startAyah && (!endAyah || endAyah < startAyah)) {
            $('#end_ayah').val(startAyah);
        }
    });
    
    // Validate end_ayah is greater than or equal to start_ayah
    $('#end_ayah').on('change', function() {
        var startAyah = parseInt($('#start_ayah').val());
        var endAyah = parseInt($(this).val());
        
        if (startAyah && endAyah < startAyah) {
            alert('Ayat selesai harus lebih besar atau sama dengan ayat mulai');
            $(this).val(startAyah);
        }
    });
});
</script>
@endsection