@extends('layouts.dashboard')

@section('title', 'Edit Presensi')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-0">Edit Presensi</h1>
                <p class="text-muted">Perbarui data presensi siswa</p>
            </div>
            <div class="d-flex gap-1">
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary" title="Kembali">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Edit Presensi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_id" class="form-label">Siswa</label>
                                <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ (old('student_id', $attendance->student_id) == $student->id) ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->grade ?? 'Kelas tidak diketahui' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $attendance->start_time) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="end_time" class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $attendance->end_time) }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status Kehadiran</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-present" value="present" {{ (old('status', $attendance->status) == 'present') ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="status-present">
                                            <span class="badge bg-success">Hadir</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-late" value="late" {{ (old('status', $attendance->status) == 'late') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status-late">
                                            <span class="badge bg-warning">Terlambat</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-absent" value="absent" {{ (old('status', $attendance->status) == 'absent') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status-absent">
                                            <span class="badge bg-danger">Tidak Hadir</span>
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="material" class="form-label">Materi</label>
                                <input type="text" class="form-control @error('material') is-invalid @enderror" id="material" name="material" value="{{ old('material', $attendance->material) }}" placeholder="Masukkan materi yang diajarkan">
                                @error('material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $attendance->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tambahkan catatan atau keterangan terkait kehadiran siswa (opsional).</div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary" title="Batal">
                                <i class="fa fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success" title="Simpan Perubahan">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
 
 