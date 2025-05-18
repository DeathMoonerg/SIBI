@extends('layouts.dashboard')

@section('title', 'Tambah Presensi - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0">Tambah Presensi</h1>
                        <p class="text-muted">Catat presensi untuk anak didik</p>
                    </div>
                    <div>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary" title="Kembali">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            
                            @if(isset($schedule))
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                            @endif
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Informasi Dasar</h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="student_id" class="form-label">Anak Didik <span class="text-danger">*</span></label>
                                    <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" {{ isset($selectedStudent) ? 'disabled' : '' }} required>
                                        <option value="">-- Pilih Anak Didik --</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ (isset($selectedStudent) && $selectedStudent->id == $student->id) || old('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }} - {{ $student->grade }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(isset($selectedStudent))
                                        <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                                    @endif
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', isset($schedule) ? $schedule->date->format('Y-m-d') : date('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', isset($schedule) ? $schedule->start_time : '') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', isset($schedule) ? $schedule->end_time : '') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Status Kehadiran</h5>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_present" value="present" {{ old('status', 'present') == 'present' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="status_present">
                                                <span class="badge bg-success">Hadir</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_late" value="late" {{ old('status') == 'late' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_late">
                                                <span class="badge bg-warning">Terlambat</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_absent" value="absent" {{ old('status') == 'absent' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_absent">
                                                <span class="badge bg-danger">Tidak Hadir</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Detail Pembelajaran</h5>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="material" class="form-label">Materi yang Dipelajari <span class="text-danger">*</span></label>
                                    <textarea name="material" id="material" rows="3" class="form-control @error('material') is-invalid @enderror" placeholder="Jelaskan materi yang telah dipelajari pada pertemuan ini" required>{{ old('material') }}</textarea>
                                    @error('material')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">Catatan Tambahan</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Tambahkan catatan tambahan jika diperlukan">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn btn-secondary" title="Reset Form">
                                            <i class="fa fa-refresh"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-success" title="Simpan Presensi">
                                            <i class="fa fa-save"></i> Simpan Presensi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                @if(isset($selectedStudent))
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Informasi Anak Didik</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $selectedStudent->name }}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                                <h5>{{ $selectedStudent->name }}</h5>
                                <p class="text-muted">{{ $selectedStudent->grade }}</p>
                            </div>
                            
                            <div>
                                <p class="mb-2"><strong>Usia:</strong> {{ $selectedStudent->age }} tahun</p>
                                <p class="mb-2"><strong>Program:</strong> {{ $selectedStudent->program }}</p>
                                <p class="mb-2"><strong>Jadwal:</strong> {{ $selectedStudent->schedule_day }}, {{ $selectedStudent->schedule_time }}</p>
                                <p class="mb-2"><strong>Alamat:</strong> {{ $selectedStudent->address }}</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Presensi Terakhir</h5>
                        </div>
                        <div class="card-body">
                            @if(count($recentAttendances) > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentAttendances as $attendance)
                                            <tr>
                                                <td>{{ $attendance->date->format('d M Y') }}</td>
                                                <td>
                                                    @if($attendance->status == 'present')
                                                        <span class="badge bg-success">Hadir</span>
                                                    @elseif($attendance->status == 'absent')
                                                        <span class="badge bg-danger">Tidak Hadir</span>
                                                    @elseif($attendance->status == 'late')
                                                        <span class="badge bg-warning">Terlambat</span>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Diketahui</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('attendance.index', ['student_id' => $selectedStudent->id]) }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Semua
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="mb-0">Belum ada riwayat presensi.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fa fa-info-circle fa-4x text-muted"></i>
                                </div>
                                <h5>Informasi</h5>
                                <p class="text-muted">Pilih anak didik terlebih dahulu untuk melihat informasi detail.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 
 
 
 
 