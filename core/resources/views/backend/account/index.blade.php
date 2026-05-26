@extends('backend.app')

@section('content')
<div class="container py-5">
    <div class="account-card">
        <div class="profile-section text-center">

            <!-- Profile Image -->
            <div class="profile-img mb-3">
                @if(isset($account) && $account->image)
                    <img src="{{ config('app.storage_url') }}{{ $account->image }}" 
                         alt="{{ $account->name ?? 'User' }}"
                         class="rounded-circle shadow"
                         style="width:120px;height:120px;object-fit:cover;">
                @else
                    <div class="profile-fallback rounded-circle shadow d-flex align-items-center justify-content-center"
                         style="width:120px;height:120px;font-size:40px;background:#343a40;color:white;">
                        {{ isset($account->name) ? strtoupper(substr($account->name, 0, 1)) : 'U' }}
                    </div>
                @endif
            </div>

            <!-- Account Info -->
            <div class="account-info mt-3">
                <h4 class="mb-3">{{ $account->name ?? 'Not set' }}</h4>

                <p class="mb-1">
                    <strong>Phone:</strong> 
                    {{ $account->phone ?? 'Not set' }}
                </p>

                <p class="mb-1">
                    <strong>Email:</strong> 
                    {{ $account->email ?? 'Not set' }}
                </p>

                <p class="mb-3">
                    <strong>Website:</strong> 
                    @if(!empty($account->website))
                        <a href="{{ $account->website }}" target="_blank">
                            {{ $account->website }}
                        </a>
                    @else
                        Not set
                    @endif
                </p>
            </div>

            <!-- Edit Button -->
            <div class="edit-btn mt-3">
                <a href="{{ url('/admin/account/edit') }}" 
                   class="btn btn-dark rounded-3 px-4 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit Account
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
/* Card Styling */
.account-card {
    background-color: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-width: 700px;
    margin: 0 auto;
    transition: all 0.3s ease;
}
.account-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Profile Section */
.profile-section {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

/* Profile Image */
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

/* Account Info */
.account-info {
    flex-grow: 1;
    margin-left: 20px;
}
.account-info h3 {
    margin-bottom: 5px;
    font-weight: 600;
}
.account-info p {
    margin: 0;
}

/* Edit Button */
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
.edit-btn a i {
    font-size: 1.1rem;
}
.edit-btn a:hover {
    background-color: #0b5ed7;
}

/* Responsive */
@media (max-width: 576px) {
    .profile-section {
        flex-direction: column;
        text-align: center;
    }
    .account-info {
        margin-left: 0;
        margin-top: 15px;
    }
    .edit-btn {
        margin-top: 15px;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .account-card {
        background-color: #1c1c1e;
        box-shadow: 0 4px 12px rgba(255,255,255,0.05);
    }
    .account-info h3, .account-info p {
        color: #f1f1f1;
    }
    .profile-fallback {
        background-color: #495057;
        border-color: #0d6efd;
    }
}
</style>
@endsection