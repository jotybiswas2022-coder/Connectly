@extends('backend.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>
                        Edit Account
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ url('/admin/account/update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input 
                                type="text" 
                                name="name"
                                class="form-control form-control-lg shadow-sm"
                                value="{{ $account->name ?? '' }}"
                                placeholder="Enter name"
                                required
                            >
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input 
                                type="text" 
                                name="phone"
                                class="form-control shadow-sm"
                                value="{{ $account->phone ?? '' }}"
                                placeholder="Enter phone number"
                            >
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input 
                                type="email" 
                                name="email"
                                class="form-control shadow-sm"
                                value="{{ $account->email ?? '' }}"
                                placeholder="Enter email address"
                            >
                        </div>

                        <!-- Website -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Website</label>
                            <input 
                                type="url" 
                                name="website"
                                class="form-control shadow-sm"
                                value="{{ $account->website ?? '' }}"
                                placeholder="https://example.com"
                            >
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Profile Picture</label>
                            <input 
                                type="file" 
                                accept="image/*" 
                                name="image"
                                class="form-control shadow-sm"
                                onchange="previewImage(event)"
                            >

                            <div class="mt-3 text-center">
                                <img id="preview"
                                     @if(isset($account) && $account->image)
                                         src="{{ config('app.storage_url') }}{{ $account->image }}" 
                                         style="display:block;"
                                     @else
                                         src=""
                                         style="display:none;"
                                     @endif
                                     class="img-fluid rounded-circle shadow-sm"
                                     style="max-width:120px;">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg rounded-3 shadow-sm">
                                <i class="bi bi-check-circle me-1"></i>
                                Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Image Preview Script --}}
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
    }
}
</script>

{{-- Custom CSS --}}
<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .card {
        background-color: #1c1c1e;
    }
    .card-body, .card-header {
        color: #f1f1f1;
    }
    input.form-control {
        background-color: #2c2c2e;
        color: #f1f1f1;
        border-color: #444;
    }
    input.form-control:focus {
        background-color: #2c2c2e;
        color: #f1f1f1;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
    }
}
</style>

@endsection