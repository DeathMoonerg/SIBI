@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="card-title">Detail Laporan Perkembangan</h2>
                        <p class="card-text">{{ $progress->date->format('l, d F Y') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('progress.detail', ['student_id' => $progress->student_id]) }}" class="btn btn-sm btn-secondary" title="Kembali">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        
                        @if(auth()->user()->role === 'teacher')
                            <a href="{{ route('progress.edit', $progress->id) }}" class="btn btn-sm btn-warning" title="Edit Laporan">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informasi Anak</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($progress->student->profile_photo_path)
                            <img src="{{ asset('storage/' . $progress->student->profile_photo_path) }}" 
                                 alt="{{ $progress->student->name }}" 
                                 class="rounded-circle mb-3 student-photo" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                        @else
                            <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center mx-auto student-photo-placeholder" 
                                 style="width: 120px; height: 120px; background-color: #e9ecef; border: 3px solid #e9ecef;">
                                <i class="fas fa-user-graduate fa-3x text-primary"></i>
                            </div>
                        @endif
                        <h4 class="student-name mb-1">{{ $progress->student->name }}</h4>
                        <p class="text-muted mb-2">{{ $progress->student->grade }}</p>
                        <div class="student-program mb-3">
                            <span class="badge bg-primary">{{ $progress->student->program }}</span>
                        </div>
                    </div>
                    
                    <div class="student-info">
                        <div class="info-item mb-3">
                            <h6 class="d-flex align-items-center">
                                <i class="fa fa-calendar-alt me-2 text-primary"></i>
                                <span>Tanggal Pertemuan</span>
                            </h6>
                            <p class="mb-0 ps-4">{{ $progress->date->format('d F Y') }}</p>
                        </div>
                    
                        <div class="info-item mb-3">
                            <h6 class="d-flex align-items-center">
                                <i class="fa fa-clock me-2 text-primary"></i>
                                <span>Waktu Belajar</span>
                            </h6>
                            <p class="mb-0 ps-4">{{ $progress->start_time }} - {{ $progress->end_time }}</p>
                        </div>
                        
                        <div class="info-item mb-3">
                            <h6 class="d-flex align-items-center">
                                <i class="fa fa-chalkboard-teacher me-2 text-primary"></i>
                                <span>Pengajar</span>
                            </h6>
                            <p class="mb-0 ps-4">{{ $progress->teacher->name }}</p>
                        </div>
                        
                        <div class="info-item mb-3">
                            <h6 class="d-flex align-items-center">
                                <i class="fa fa-check-circle me-2 text-primary"></i>
                                <span>Status Verifikasi</span>
                            </h6>
                            <p class="mb-0 ps-4">
                                @if($progress->is_verified)
                                    <span class="badge bg-{{ $progress->verification_status === 'approved' ? 'success' : 'danger' }}">
                                        {{ $progress->verification_status === 'approved' ? 'Terverifikasi' : 'Ditolak' }}
                                    </span>
                                    <small class="d-block text-muted mt-1">
                                        Diverifikasi oleh {{ $progress->verifier->name ?? 'Admin' }} pada {{ $progress->verified_at->format('d/m/Y H:i') }}
                                    </small>
                                    @if($progress->verification_note)
                                        <small class="d-block text-muted mt-1">
                                            Catatan: {{ $progress->verification_note }}
                                        </small>
                                    @endif
                                @else
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="info-item">
                            <h6 class="d-flex align-items-center">
                                <i class="fa fa-user-friends me-2 text-primary"></i>
                                <span>Orang Tua</span>
                            </h6>
                            <p class="mb-0 ps-4">{{ $progress->student->parent->name ?? 'Belum diatur' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Perkembangan</h5>
                    @if(auth()->user()->role === 'teacher' && !$progress->is_verified)
                        <div class="verification-controls">
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal">
                                <i class="fa fa-check"></i> Verifikasi
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="progress-overall mb-4">
                        <h6 class="mb-2">Nilai Keseluruhan</h6>
                        <div class="progress">
                            <div class="progress-bar bg-{{ getScoreColor($progress->score) }} progress-bar-width" 
                                role="progressbar" 
                                data-width="{{ $progress->score }}"
                                aria-valuenow="{{ $progress->score }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">{{ $progress->score }}%</div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="progress-detail-item">
                                <h6><i class="fa fa-book me-2 text-primary"></i>Materi yang Dipelajari</h6>
                                <p>{{ $progress->material_covered }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="progress-detail-item">
                                <h6><i class="fa fa-trophy me-2 text-primary"></i>Pencapaian</h6>
                                <p>{{ $progress->achievements }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="progress-detail-item">
                                <h6><i class="fa fa-exclamation-triangle me-2 text-primary"></i>Tantangan</h6>
                                <p>{{ $progress->challenges }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="progress-detail-item">
                                <h6><i class="fa fa-sticky-note me-2 text-primary"></i>Catatan Tambahan</h6>
                                <p>{{ $progress->notes ?? 'Tidak ada catatan tambahan.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Komentar</h5>
                </div>
                <div class="card-body">
                    @if(!empty($progress->parent_comment))
                        <div class="comment-item mb-4">
                            <div class="d-flex">
                                <div class="comment-avatar bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user-friends fa-lg"></i>
                                </div>
                                <div class="comment-content ms-3 w-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $progress->student->parent->name }} <span class="badge bg-info">Orang Tua</span></h6>
                                            <p class="comment-time text-muted mb-2">{{ $progress->parent_comment_at->format('d F Y, H:i') }}</p>
                                        </div>
                                        @if(auth()->user()->role === 'parent')
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-sm btn-warning" onclick="editParentComment()" title="Edit Komentar">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('progress.deleteComment', $progress) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Komentar">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    <div id="parentCommentText" class="comment-text p-3 rounded">
                                        {{ $progress->parent_comment }}
                                    </div>
                                    <form id="editParentCommentForm" action="{{ route('progress.updateComment', $progress) }}" method="POST" class="mt-2 d-none">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-2">
                                            <textarea name="parent_comment" class="form-control" rows="3" required>{{ $progress->parent_comment }}</textarea>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="cancelEditParentComment()" title="Batal">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-success" title="Simpan">
                                                <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        @if(!empty($progress->teacher_reply))
                            <div class="comment-item mb-4 ps-5">
                                <div class="d-flex">
                                    <div class="comment-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-chalkboard-teacher fa-lg"></i>
                                    </div>
                                    <div class="comment-content ms-3 w-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $progress->teacher->name }} <span class="badge bg-primary">Guru</span></h6>
                                                <p class="comment-time text-muted mb-2">{{ $progress->teacher_reply_at->format('d F Y, H:i') }}</p>
                                            </div>
                                            @if(auth()->user()->role === 'teacher')
                                            <div class="d-flex gap-1">
                                                <button type="button" class="btn btn-sm btn-warning" onclick="editTeacherReply()" title="Edit Balasan">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('progress.deleteReply', $progress) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Balasan">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                        <div id="teacherReplyText" class="comment-text p-3 rounded">
                                            {{ $progress->teacher_reply }}
                                        </div>
                                        <form id="editTeacherReplyForm" action="{{ route('progress.updateReply', $progress) }}" method="POST" class="mt-2 d-none">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <textarea name="teacher_reply" class="form-control" rows="3" required>{{ $progress->teacher_reply }}</textarea>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="cancelEditTeacherReply()" title="Batal">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-success" title="Simpan">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elseif(auth()->user()->role === 'teacher' && !empty($progress->parent_comment))
                            <div class="ps-5 mb-4">
                                <form action="{{ route('progress.reply', $progress->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="teacher_reply" class="form-label">Balas Komentar Orang Tua</label>
                                        <textarea name="teacher_reply" id="teacher_reply" rows="3" class="form-control @error('teacher_reply') is-invalid @enderror" required>{{ old('teacher_reply') }}</textarea>
                                        @error('teacher_reply')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success" title="Kirim Balasan">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @elseif(auth()->user()->role === 'parent' && empty($progress->parent_comment))
                        <form action="{{ route('progress.comment', $progress->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="parent_comment" class="form-label">Tambahkan Komentar</label>
                                <textarea name="parent_comment" id="parent_comment" rows="3" class="form-control @error('parent_comment') is-invalid @enderror" required>{{ old('parent_comment') }}</textarea>
                                @error('parent_comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-sm btn-success" title="Kirim Komentar">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </form>
                    @else
                        <p class="text-muted mb-0">Belum ada komentar.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role === 'teacher')
<!-- Verification Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifyModalLabel">Verifikasi Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('progress.verify', $progress) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select name="verification_status" class="form-select" required>
                            <option value="approved">Setujui</option>
                            <option value="rejected">Tolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Verifikasi</label>
                        <textarea name="verification_note" class="form-control" rows="3" required placeholder="Berikan catatan untuk verifikasi ini..."></textarea>
                        <small class="text-muted">Catatan ini akan ditampilkan kepada orang tua siswa</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($progress->is_verified)
<!-- Unverify Modal -->
<div class="modal fade" id="unverifyModal" tabindex="-1" aria-labelledby="unverifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unverifyModalLabel">Batalkan Verifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan verifikasi laporan ini?</p>
                <small class="text-muted">Membatalkan verifikasi akan mengembalikan status laporan menjadi "Menunggu Verifikasi"</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('progress.unverify', $progress) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Batalkan Verifikasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection

@section('styles')
<style>
.progress-detail-item {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    height: 100%;
}

.progress-detail-item h6 {
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--dark);
}

.progress-detail-item p {
    margin-bottom: 0;
    color: #666;
}

.comment-avatar {
    flex-shrink: 0;
}

.comment-text {
    background-color: #f0f2f5;
    border-radius: 0 10px 10px 10px !important;
}

.comment-item.ps-5 .comment-text {
    background-color: #e6f7ff;
    border-radius: 10px 0 10px 10px !important;
}

.progress-bar-width {
    transition: width 0.6s ease;
}

.student-info .info-item {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 1rem;
}

.student-info .info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.student-info .info-item h6 {
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.student-info .info-item p {
    color: #6c757d;
    font-size: 0.95rem;
}

.student-photo {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.student-photo:hover {
    transform: scale(1.05);
}

.student-name {
    color: #2c3e50;
    font-weight: 600;
}

.student-program .badge {
    font-size: 0.85rem;
    padding: 0.5em 1em;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set progress bar width
    const progressBars = document.querySelectorAll('.progress-bar-width');
    progressBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        bar.style.width = width + '%';
    });
});

function editParentComment() {
    const commentText = document.getElementById('parentCommentText');
    const editForm = document.getElementById('editParentCommentForm');
    
    if (commentText && editForm) {
        commentText.classList.add('d-none');
        editForm.classList.remove('d-none');
    }
}

function cancelEditParentComment() {
    const commentText = document.getElementById('parentCommentText');
    const editForm = document.getElementById('editParentCommentForm');
    
    if (commentText && editForm) {
        commentText.classList.remove('d-none');
        editForm.classList.add('d-none');
    }
}

function editTeacherReply() {
    const replyText = document.getElementById('teacherReplyText');
    const editForm = document.getElementById('editTeacherReplyForm');
    
    if (replyText && editForm) {
        replyText.classList.add('d-none');
        editForm.classList.remove('d-none');
    }
}

function cancelEditTeacherReply() {
    const replyText = document.getElementById('teacherReplyText');
    const editForm = document.getElementById('editTeacherReplyForm');
    
    if (replyText && editForm) {
        replyText.classList.remove('d-none');
        editForm.classList.add('d-none');
    }
}
</script>
@endsection 
 
 