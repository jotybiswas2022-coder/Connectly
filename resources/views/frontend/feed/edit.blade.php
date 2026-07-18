@extends('frontend.app')

@section('content')

<div class="connectly-edit-page">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <a href="{{ route('feed') }}" class="connectly-edit-back mb-3 d-inline-flex align-items-center gap-2 text-decoration-none">
                    <i class="bi bi-arrow-left"></i>
                    Back to Feed
                </a>

                <div class="connectly-edit-card">
                    <div class="d-flex align-items-start gap-3">
                        @if(auth()->user()->avatar_path)
                            <img src="{{ route('media.show', ['path' => auth()->user()->avatar_path]) }}"
                                 alt="My avatar"
                                 class="connectly-feed-avatar connectly-feed-avatar-image">
                        @else
                            <div class="connectly-feed-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ auth()->user()->name }}</h6>
                            <p class="mb-3 text-muted small">Editing your post</p>

                            @php
                                $postImages = $post->images ?? [];
                                $imageCount = count($postImages);
                            @endphp

                            <form action="{{ route('feed.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Post Content</label>
                                    <textarea
                                        name="edit_content"
                                        class="form-control connectly-edit-textarea @error('edit_content', 'editPost_' . $post->id) is-invalid @enderror"
                                        rows="5"
                                        placeholder="Update your post..."
                                        maxlength="600"
                                    >{{ old('edit_content', $post->content) }}</textarea>
                                    @error('edit_content', 'editPost_' . $post->id)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text connectly-edit-charcount">{{ mb_strlen(old('edit_content', $post->content)) }}/600</div>
                                </div>

                                @if ($imageCount > 0)
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">
                                            <i class="bi bi-images me-1"></i>Current Images
                                        </label>
                                        <div class="connectly-edit-existing-images">
                                            @foreach ($postImages as $imgPath)
                                                <div class="connectly-edit-existing-item">
                                                    <img src="{{ route('media.show', ['path' => $imgPath]) }}" alt="Post image" loading="lazy">
                                                    <label class="connectly-edit-remove-check">
                                                        <input type="checkbox" name="remove_images[]" value="{{ $imgPath }}" onchange="this.parentElement.style.opacity=this.checked?'0.6':'1'">
                                                        Remove
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">
                                        <i class="bi bi-cloud-arrow-up me-1"></i>Add More Images
                                    </label>
                                    <div class="connectly-file-upload">
                                        <input
                                            type="file"
                                            name="edit_images[]"
                                            accept="image/*"
                                            multiple
                                            class="connectly-file-input connectly-edit-image-input"
                                            id="editImageInput"
                                            data-preview-container="editPreview"
                                        >
                                        <label for="editImageInput" class="connectly-file-label">
                                            <i class="bi bi-cloud-arrow-up me-2"></i>
                                            <span>Click to add more images</span>
                                        </label>
                                    </div>
                                    <div id="editPreview" class="connectly-edit-preview-grid mt-2"></div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('feed') }}" class="btn btn-outline-secondary connectly-edit-cancel-btn">Cancel</a>
                                    <button type="submit" class="btn btn-primary connectly-edit-save-btn">
                                        <i class="bi bi-check-lg me-1"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --feed-bg: #f5f5f7;
    --feed-surface: #ffffff;
    --feed-border: #e5e7eb;
    --feed-border-light: #f0f0f2;
    --feed-primary: #0071e3;
    --feed-primary-dark: #0058b3;
    --feed-text: #1d1d1f;
    --feed-text-secondary: #424245;
    --feed-muted: #86868b;
    --feed-muted-light: #aeaeb2;
    --feed-input-bg: #f5f5f7;
    --feed-input-border: #d2d2d7;
    --feed-radius: 24px;
    --feed-radius-sm: 14px;
    --feed-shadow-sm: 0 1px 2px rgba(0,0,0,0.03);
    --feed-shadow-md: 0 2px 8px rgba(0,0,0,0.04);
    --feed-shadow-lg: 0 8px 24px rgba(0,0,0,0.05);
    --feed-transition: 0.25s cubic-bezier(.4,0,.2,1);
}

.connectly-edit-page {
    min-height: 100vh;
    background: var(--feed-bg);
}

.connectly-edit-back {
    color: var(--feed-muted);
    font-size: 0.88rem;
    font-weight: 500;
    padding: 0.4rem 0.8rem;
    border-radius: var(--feed-radius-pill, 9999px);
    transition: all var(--feed-transition);
}

.connectly-edit-back:hover {
    color: var(--feed-primary);
    background: rgba(0,113,227,0.06);
}

.connectly-edit-card {
    background: var(--feed-surface);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.75rem;
    box-shadow: var(--feed-shadow-sm);
    animation: editCardSlideUp 0.4s ease-out;
}

@keyframes editCardSlideUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.connectly-edit-textarea {
    border-radius: var(--feed-radius-sm);
    border: 1.5px solid var(--feed-input-border);
    padding: 1rem 1.1rem;
    resize: vertical;
    font-size: 0.9rem;
    background: var(--feed-input-bg);
    color: var(--feed-text);
    transition: border-color var(--feed-transition), box-shadow var(--feed-transition);
    line-height: 1.6;
}

.connectly-edit-textarea:focus {
    border-color: var(--feed-primary);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.1);
    background: var(--feed-surface);
    outline: none;
}

.connectly-edit-charcount {
    text-align: right;
    font-size: 0.75rem;
    color: var(--feed-muted-light);
    margin-top: 0.3rem;
}

.connectly-edit-existing-images {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.connectly-edit-existing-item {
    position: relative;
    width: 100px;
    height: 100px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--feed-border);
}

.connectly-edit-existing-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.connectly-edit-remove-check {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.6);
    color: #fff;
    font-size: 0.65rem;
    padding: 3px 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 3px;
    cursor: pointer;
    transition: opacity 0.2s;
}

.connectly-edit-remove-check input {
    accent-color: var(--feed-danger, #dc2626);
}

.connectly-edit-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
    gap: 0.4rem;
}

.connectly-edit-preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid var(--feed-border);
    background: var(--feed-surface);
    animation: previewItemIn 0.25s ease backwards;
}

.connectly-edit-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@keyframes previewItemIn {
    from { opacity: 0; transform: scale(0.85); }
    to { opacity: 1; transform: scale(1); }
}

.connectly-edit-cancel-btn {
    border-radius: var(--feed-radius-pill, 9999px) !important;
    padding: 0.55rem 1.5rem !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
    color: var(--feed-muted) !important;
    border-color: var(--feed-border) !important;
}

.connectly-edit-cancel-btn:hover {
    background: var(--feed-input-bg) !important;
    color: var(--feed-text) !important;
}

.connectly-edit-save-btn {
    border-radius: var(--feed-radius-pill, 9999px) !important;
    padding: 0.55rem 1.75rem !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark)) !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(0,113,227,0.2) !important;
}

.connectly-edit-save-btn:hover {
    box-shadow: 0 6px 18px rgba(0,113,227,0.3) !important;
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.querySelector('.connectly-edit-textarea');
    const charCount = document.querySelector('.connectly-edit-charcount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function () {
            charCount.textContent = this.value.length + '/600';
        });
    }
});

document.addEventListener('change', function(e) {
    if (e.target.matches('.connectly-edit-image-input')) {
        const containerId = e.target.dataset.previewContainer;
        const container = document.getElementById(containerId);
        if (!container) return;

        container.innerHTML = '';
        const files = Array.from(e.target.files || []);
        if (files.length === 0) return;

        files.forEach((file, index) => {
            const reader = new FileReader();
            const item = document.createElement('div');
            item.className = 'connectly-edit-preview-item';
            item.style.animation = 'previewItemIn 0.25s ease backwards';
            item.style.animationDelay = (index * 0.05) + 's';

            reader.onload = function(ev) {
                item.innerHTML = `<img src="${ev.target.result}" alt="New image ${index + 1}">`;
            };
            reader.readAsDataURL(file);
            container.appendChild(item);
        });
    }
});
</script>

@endsection
