@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Contact Messages</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr class="{{ $contact->is_read ? '' : 'table-warning' }}">
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td>{{ Str::limit($contact->message, 50) }}</td>
                        <td>{{ $contact->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($contact->is_read)
                                <span class="badge bg-success">Read</span>
                            @else
                                <span class="badge bg-warning">Unread</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal{{ $contact->id }}">
                                <i class="fas fa-eye"></i> View
                            </button>
                            
                            @if(!$contact->is_read)
                                <form action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Mark as Read
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Modal for viewing contact message -->
                    <div class="modal fade" id="contactModal{{ $contact->id }}" tabindex="-1" aria-labelledby="contactModalLabel{{ $contact->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="contactModalLabel{{ $contact->id }}">Contact Message from {{ $contact->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong>Name:</strong> {{ $contact->name }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email:</strong> {{ $contact->email }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Subject:</strong> {{ $contact->subject ?: 'N/A' }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Message:</strong>
                                        <div class="p-3 bg-light mt-2">
                                            {{ $contact->message }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Date Received:</strong> {{ $contact->created_at->format('F d, Y H:i:s') }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @if($contact->is_read)
                                            <span class="badge bg-success">Read on {{ $contact->read_at->format('F d, Y H:i:s') }}</span>
                                        @else
                                            <span class="badge bg-warning">Unread</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if(!$contact->is_read)
                                        <form action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No contact messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
    </div>
</div>
@endsection 