@extends('layouts.dashboard')

@section('title', 'Tambah Laporan Perkembangan - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="card-title">Tambah Laporan Perkembangan</h2>
                            <p class="card-text">Isi laporan perkembangan anak didik dengan lengkap.</p>
                        </div>
                        <div>
                            <a href="{{ route('progress.index') }}" class="btn btn-secondary" title="Kembali">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('progress.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Informasi Umum</h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="student_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                                    <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ (isset($selectedStudentId) && $selectedStudentId == $student->id) ? 'selected' : '' }}>{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Detail Pembelajaran</h5>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="material_covered" class="form-label">Materi yang Dipelajari <span class="text-danger">*</span></label>
                                    <textarea name="material_covered" id="material_covered" rows="3" class="form-control @error('material_covered') is-invalid @enderror" placeholder="Jelaskan materi yang telah dipelajari pada pertemuan ini" required>{{ old('material_covered') }}</textarea>
                                    @error('material_covered')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="achievements" class="form-label">Pencapaian <span class="text-danger">*</span></label>
                                    <textarea name="achievements" id="achievements" rows="3" class="form-control @error('achievements') is-invalid @enderror" placeholder="Jelaskan pencapaian anak didik pada pertemuan ini" required>{{ old('achievements') }}</textarea>
                                    @error('achievements')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="challenges" class="form-label">Tantangan <span class="text-danger">*</span></label>
                                    <textarea name="challenges" id="challenges" rows="3" class="form-control @error('challenges') is-invalid @enderror" placeholder="Jelaskan tantangan yang dihadapi anak didik pada pertemuan ini" required>{{ old('challenges') }}</textarea>
                                    @error('challenges')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Penilaian</h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="score" class="form-label">Nilai Pertemuan (0-100) <span class="text-danger">*</span></label>
                                    <input type="number" name="score" id="score" class="form-control @error('score') is-invalid @enderror" min="0" max="100" value="{{ old('score', 70) }}" required>
                                    @error('score')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="overall_score" class="form-label">Nilai Keseluruhan (0-100)</label>
                                    <input type="number" name="overall_score" id="overall_score" class="form-control @error('overall_score') is-invalid @enderror" min="0" max="100" value="{{ old('overall_score') }}">
                                    <small class="text-muted">Kosongkan untuk menggunakan nilai pertemuan sebagai nilai keseluruhan</small>
                                    @error('overall_score')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">Catatan Tambahan</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Tambahkan catatan lain yang perlu diperhatikan oleh orang tua">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('progress.index') }}" class="btn btn-secondary" title="Batal">
                                    <i class="fa fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success" title="Simpan Laporan">
                                    <i class="fa fa-save"></i> Simpan Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Menampilkan preview dari score
    $('#score').on('input', function() {
        var score = $(this).val();
        var scoreClass = 'text-danger';
        
        if (score >= 85) {
            scoreClass = 'text-success';
        } else if (score >= 70) {
            scoreClass = 'text-primary';
        } else if (score >= 60) {
            scoreClass = 'text-warning';
        }
        
        $('#score-preview').removeClass('text-success text-primary text-warning text-danger').addClass(scoreClass);
    });
});
</script>
@endsection 
 
 
 
 