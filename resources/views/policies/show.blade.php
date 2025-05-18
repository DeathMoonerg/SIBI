@extends('layouts.dashboard')

@section('title', 'Detail Kebijakan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kebijakan</h1>
        <div>
            <a href="{{ route('policies.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('policies.edit', $policy->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $policy->title }}</h6>
        </div>
        <div class="card-body">
            <div class="policy-header mb-4 border-bottom pb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span class="text-muted">Kategori:</span>
                            <span class="fw-bold">{{ $policy->category ?? 'Tidak Dikategorikan' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Status:</span>
                            @if ($policy->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span class="text-muted">Dibuat Oleh:</span>
                            <span class="fw-bold">{{ $policy->creator->name ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Tanggal Dibuat:</span>
                            <span class="fw-bold">{{ $policy->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Terakhir Diperbarui:</span>
                            <span class="fw-bold">{{ $policy->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if ($policy->updated_by)
                        <div>
                            <span class="text-muted">Diperbarui Oleh:</span>
                            <span class="fw-bold">{{ $policy->updater->name ?? 'N/A' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="policy-content">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Isi Kebijakan</h6>
                    </div>
                    <div class="card-body">
                        <div class="policy-text">
                            {!! nl2br(e($policy->content)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 