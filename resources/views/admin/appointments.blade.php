@extends('layouts.admin')

@section('title', 'Appointments')
@section('page-title', 'Appointment Requests')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Appointment Requests</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Guardian</th>
                        <th>Child</th>
                        <th>Age</th>
                        <th>Class</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr class="{{ $appointment->status === 'pending' ? 'table-warning' : ($appointment->status === 'confirmed' ? 'table-success' : 'table-danger') }}">
                        <td>{{ $appointment->id }}</td>
                        <td>
                            {{ $appointment->guardian_name }}<br>
                            <small>{{ $appointment->guardian_email }}</small>
                        </td>
                        <td>{{ $appointment->child_name }}</td>
                        <td>{{ $appointment->child_age }}</td>
                        <td>{{ $appointment->schoolClass ? $appointment->schoolClass->name : 'N/A' }}</td>
                        <td>{{ $appointment->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'confirmed' ? 'success' : 'danger') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#appointmentModal{{ $appointment->id }}">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Modal for viewing and updating appointment -->
                    <div class="modal fade" id="appointmentModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="appointmentModalLabel{{ $appointment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="appointmentModalLabel{{ $appointment->id }}">Appointment Request #{{ $appointment->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Guardian Name:</strong> {{ $appointment->guardian_name }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Guardian Email:</strong> {{ $appointment->guardian_email }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Child Name:</strong> {{ $appointment->child_name }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Child Age:</strong> {{ $appointment->child_age }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Class:</strong> {{ $appointment->schoolClass ? $appointment->schoolClass->name : 'N/A' }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Date Requested:</strong> {{ $appointment->created_at->format('F d, Y H:i:s') }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Status:</strong>
                                                <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'confirmed' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Appointment Date:</strong> {{ $appointment->appointment_date ? $appointment->appointment_date->format('F d, Y H:i') : 'Not Scheduled' }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Message:</strong>
                                        <div class="p-3 bg-light mt-2">
                                            {{ $appointment->message ?: 'No message provided.' }}
                                        </div>
                                    </div>
                                    
                                    @if($appointment->admin_notes)
                                    <div class="mb-3">
                                        <strong>Admin Notes:</strong>
                                        <div class="p-3 bg-light mt-2">
                                            {{ $appointment->admin_notes }}
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <form action="{{ route('admin.appointments.update-status', $appointment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Update Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="canceled" {{ $appointment->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="admin_notes" class="form-label">Admin Notes</label>
                                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ $appointment->admin_notes }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No appointment requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection 