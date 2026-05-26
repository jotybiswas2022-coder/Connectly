@extends('backend.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Dashboard Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-4 shadow-lg" style="background: linear-gradient(135deg, #cd3a05, #a7030e); color: #fff;">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="fw-bold fs-4 d-flex align-items-center">
                        <i class="bi bi-speedometer2 me-2 fs-3"></i>
                        Welcome to Admin Dashboard
                    </div>
                    <div class="mt-2 mt-md-0 fw-semibold">
                        Hello, <strong>{{ $account->name ?? 'Admin' }}</strong>! Here's a quick overview.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-hover p-3 shadow-sm rounded-4 text-center">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h3 class="mt-2">{{ $accountsCount }}</h3>
                <p class="mb-0 fw-semibold">Total Admins</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-hover p-3 shadow-sm rounded-4 text-center">
                <i class="bi bi-envelope fs-1 text-success"></i>
                <h3 class="mt-2">{{ $contactsCount }}</h3>
                <p class="mb-0 fw-semibold">Total Messages</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-hover p-3 shadow-sm rounded-4 text-center">
                <i class="bi bi-people fs-1 text-info"></i>
                <h3 class="mt-2">{{ $usersCount }}</h3>
                <p class="mb-0 fw-semibold">Total Users</p>
            </div>
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card rounded-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-chat-dots me-2"></i> Recent Messages
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($contacts->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 mb-2"></i>
                            <div>No messages found</div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $index => $contact)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#messageModal{{ $contact->id }}">
                                                    View
                                                </button>

                                                <div class="modal fade" id="messageModal{{ $contact->id }}" tabindex="-1" aria-labelledby="messageModalLabel{{ $contact->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content rounded-4 shadow-lg">
                                                            <div class="modal-header bg-primary text-white rounded-top-4">
                                                                <h5 class="modal-title fw-semibold">
                                                                    Message from {{ $contact->name }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body px-4 py-3">
                                                                <p>{{ $contact->message }}</p>
                                                            </div>
                                                            <div class="modal-footer border-0 px-4 pb-4">
                                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($contact->created_at)->timezone('Asia/Dhaka')->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($contact->created_at)->timezone('Asia/Dhaka')->format('h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Custom Styles --}}
<style>
.card-hover {
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}
.card-hover:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 24px rgba(0,0,0,0.2);
}
.account-card {
    background-color: #f8f9fa;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    transition: all 0.3s ease;
}
.account-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.profile-img img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #0d6efd;
}
.profile-fallback {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #6c757d;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    border: 3px solid #0d6efd;
}
.edit-btn a {
    display: inline-flex;
    align-items: center;
    background-color: #0d6efd;
    color: #fff;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s ease;
}
.edit-btn a:hover {
    background-color: #0b5ed7;
}
.table-hover tbody tr:hover {
    background: rgba(13,110,253,.05);
}
.modal-content {
    border: none;
}
</style>

@endsection