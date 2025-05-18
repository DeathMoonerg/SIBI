@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Profil Saya</h5>
                        <p class="text-muted mb-0">Informasi profil Anda</p>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning" title="Edit Profil">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="profile-icon-container mb-3">
                                @if($user->role === 'admin')
                                    <i class="fas fa-user-shield profile-icon"></i>
                                @elseif($user->role === 'teacher')
                                    <i class="fas fa-chalkboard-teacher profile-icon"></i>
                                @elseif($user->role === 'parent')
                                    <i class="fas fa-user-friends profile-icon"></i>
                                @else
                                    <i class="fas fa-user profile-icon"></i>
                                @endif
                            </div>
                            <h4>{{ $user->name }}</h4>
                            <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon</th>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $user->address ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terdaftar Pada</th>
                                        <td>{{ $user->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diperbarui</th>
                                        <td>{{ $user->updated_at->format('d F Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'teacher')
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Mengajar</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Jumlah Siswa</th>
                                        <td>{{ $user->students()->count() }} siswa</td>
                                    </tr>
                                    <tr>
                                        <th>Jadwal Mengajar</th>
                                        <td>
                                            @if($user->schedules()->count() > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($user->schedules as $schedule)
                                                        <li>{{ $schedule->day }}: {{ $schedule->start_time }} - {{ $schedule->end_time }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Belum ada jadwal mengajar
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($user->role === 'parent')
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Anak</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Anak</th>
                                            <th>Kelas</th>
                                            <th>Guru</th>
                                            <th>Program</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->children as $child)
                                        <tr>
                                            <td>{{ $child->name }}</td>
                                            <td>{{ $child->grade }}</td>
                                            <td>{{ $child->teacher->name ?? '-' }}</td>
                                            <td>{{ $child->program }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada data anak</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-icon-container {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    background-color: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #e9ecef;
}

.profile-icon {
    font-size: 80px;
    color: #6c757d;
}

.badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>
@endsection 