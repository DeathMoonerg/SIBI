@extends('layouts.dashboard')

@section('title', 'Daftar Orang Tua')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                    <h5 class="mb-0">Daftar Orang Tua</h5>
                        <p class="text-muted mb-0">Kelola data orang tua siswa</p>
                    </div>
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                    <a href="{{ route('parents.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i> Tambah Orang Tua
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Jumlah Anak</th>
                                    <th>Terdaftar Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parents as $parent)
                                <tr>
                                    <td>{{ $parent->name }}</td>
                                    <td>{{ $parent->email }}</td>
                                    <td>{{ $parent->phone ?? '-' }}</td>
                                    <td><span class="badge bg-success text-white" style="font-size: 14px; padding: 6px 10px;">{{ $parent->children_count }}</span></td>
                                    <td>{{ $parent->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('parents.show', $parent) }}" class="btn btn-primary btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                            <a href="{{ route('parents.edit', $parent) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('parents.destroy', $parent) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus orang tua ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data orang tua.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $parents->firstItem() ?? 0 }}-{{ $parents->lastItem() ?? 0 }} dari {{ $parents->total() ?? 0 }} data
                            </small>
                        </div>
                        <div>
                            @if ($parents->onFirstPage())
                                <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                            @else
                                <a href="{{ $parents->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                            @endif

                            @if ($parents->hasMorePages())
                                <a href="{{ $parents->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
                            @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.d-flex.gap-2 {
    display: flex;
    gap: 0.5rem;
}

.d-flex.gap-2 .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
}

.d-flex.gap-2 .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.d-flex.gap-2 .btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}

.d-flex.gap-2 .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.d-flex.gap-2 .btn:hover {
    opacity: 0.9;
}

.d-flex.gap-2 .btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.d-flex.gap-2 .btn i {
    font-size: 0.875rem;
}

/* Pagination Styles */
.btn-outline-primary {
    color: #0d6efd;
    border-color: #0d6efd;
}

.btn-outline-primary:hover {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:disabled {
    color: #6c757d;
    background-color: transparent;
    opacity: 0.65;
}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush 