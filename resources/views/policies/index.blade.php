@extends('layouts.dashboard')

@section('title', 'Kebijakan - Sistem Informasi Bimbel Alfarizqi')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center policy-action-row">
                    <div>
                        <h2 class="card-title">Kebijakan & Peraturan</h2>
                        <p class="card-text">Kelola kebijakan dan peraturan bimbel</p>
                    </div>
                    <div class="d-flex gap-2 policy-action-row">
                        <div class="btn-group">
                            <a href="{{ route('policies.index') }}" 
                               class="btn {{ !request('status') || request('status') == 'all' ? 'btn btn-sm' : 'btn-outline-primary' }}">
                                <i class="fa fa-list me-1"></i> Semua
                            </a>
                            <a href="{{ route('policies.index', ['status' => 'active']) }}" 
                               class="btn {{ request('status') == 'active' ? 'btn btn-sm' : 'btn-outline-primary' }}">
                                <i class="fa fa-check-circle me-1"></i> Aktif
                            </a>
                            <a href="{{ route('policies.index', ['status' => 'inactive']) }}" 
                               class="btn {{ request('status') == 'inactive' ? 'btn btn-sm' : 'btn-outline-primary' }}">
                                <i class="fa fa-times-circle me-1"></i> Nonaktif
                            </a>
                        </div>
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                        <a href="{{ route('policies.create') }}" class="btn btn-success" title="Tambah Kebijakan Baru">
                            <i class="fa fa-plus"></i> Tambah Kebijakan
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
        <div class="card-body">
            @if ($policies->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                                <thead class="bg-light">
                            <tr>
                                        <th style="width: 50px">No</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th class="d-mobile-none">Terakhir Diupdate</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($policies as $index => $policy)
                                <tr>
                                            <td class="text-center">{{ $policies->firstItem() + $index }}</td>
                                    <td>{{ $policy->title }}</td>
                                            <td>
                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('policies.toggle-status', $policy->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="btn btn-sm {{ $policy->is_active ? 'btn-success' : 'btn-danger' }}"
                                                                title="{{ $policy->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Kebijakan">
                                                            <i class="fa fa-{{ $policy->is_active ? 'check' : 'times' }} me-1"></i>
                                                            {{ $policy->is_active ? 'Aktif' : 'Nonaktif' }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-{{ $policy->is_active ? 'success' : 'danger' }}">
                                                        <i class="fa fa-{{ $policy->is_active ? 'check' : 'times' }} me-1"></i>
                                                        {{ $policy->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                @endif
                                            </td>
                                    <td>
                                                <div class="policy-user-mobile">
                                                    <div class="rounded-circle bg-{{ $policy->creator->role === 'admin' ? 'danger' : ($policy->creator->role === 'teacher' ? 'success' : 'info') }} d-flex align-items-center justify-content-center icon" style="width: 24px; height: 24px;">
                                                        <i class="fa fa-{{ $policy->creator->role === 'admin' ? 'user-shield' : ($policy->creator->role === 'teacher' ? 'chalkboard-teacher' : 'user') }} text-white"></i>
                                                    </div>
                                                    <span>{{ $policy->creator->name ?? 'N/A' }}</span>
                                                    <span class="tanggal"><i class="fa fa-clock me-1"></i>{{ $policy->created_at->format('d M Y H:i') }}</span>
                                                </div>
                                            </td>
                                            <td class="d-mobile-none">
                                                @if($policy->updated_by)
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-{{ $policy->updater->role === 'admin' ? 'danger' : ($policy->updater->role === 'teacher' ? 'success' : 'info') }} d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <i class="fa fa-{{ $policy->updater->role === 'admin' ? 'user-shield' : ($policy->updater->role === 'teacher' ? 'chalkboard-teacher' : 'user') }} text-white"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $policy->updater->name ?? 'N/A' }}</div>
                                                            <small class="text-muted">
                                                                <i class="fa fa-clock me-1"></i>
                                                                {{ $policy->updated_at->format('d M Y H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                        @else
                                                    <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                                <div class="d-flex gap-1">
                                            <a href="{{ route('policies.show', $policy->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                            <a href="{{ route('policies.edit', $policy->id) }}" class="btn btn-sm btn-warning" title="Edit Kebijakan">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                                        <form action="{{ route('policies.destroy', $policy->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kebijakan: {{ $policy->title }}? Tindakan ini tidak dapat dibatalkan.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Kebijakan">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($policies instanceof \Illuminate\Pagination\LengthAwarePaginator && $policies->total() > 0)
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $policies->firstItem() }}-{{ $policies->lastItem() }} dari {{ $policies->total() }} data
                        </small>
                    </div>
                    <div>
                        @if ($policies->onFirstPage())
                            <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                        @else
                            <a href="{{ $policies->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                        @endif

                        @if ($policies->hasMorePages())
                            <a href="{{ $policies->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
                        @else
                            <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
                        @endif
                    </div>
                </div>
                @endif
                <div class="d-flex justify-content-center mt-4">
                            {{ $policies->appends(request()->query())->links() }}
                </div>
            @else
                        <div class="text-center py-5">
                            <div class="display-1 text-muted mb-4">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h4>Belum Ada Kebijakan</h4>
                            <p class="text-muted">
                                @if(request('status') == 'active')
                                    Belum ada kebijakan yang aktif.
                                @elseif(request('status') == 'inactive')
                                    Belum ada kebijakan yang nonaktif.
                                @else
                    Belum ada kebijakan yang ditambahkan.
                                @endif
                            </p>
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                <a href="{{ route('policies.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus-circle me-1"></i> Tambah Kebijakan Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media (max-width: 767.98px) {
  .table th, .table td {
    padding: 0.3rem 0.3rem;
    font-size: 0.92rem;
    vertical-align: middle;
  }
  .badge, .btn-sm {
    font-size: 0.8rem !important;
    padding: 0.3em 0.7em !important;
  }
  .policy-user-mobile {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.4em;
    white-space: nowrap;
  }
  .policy-user-mobile .icon {
    font-size: 1rem;
    margin-right: 0.1em;
  }
  .policy-user-mobile .tanggal {
    font-size: 0.85em;
    color: #888;
    margin-left: 0.2em;
  }
  .d-mobile-none {
    display: none !important;
  }
  .policy-action-row {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 0.5rem !important;
  }
  .policy-action-row .btn-group {
    width: 100%;
    flex-wrap: wrap;
  }
  .policy-action-row .btn-group .btn {
    width: 100%;
    margin-bottom: 0.3rem;
    text-align: left;
  }
  .policy-action-row .btn-success {
    width: 100%;
  }
}
</style>
@endpush
@endsection 