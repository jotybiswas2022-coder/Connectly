@extends('frontend.app')

@section('content')

<div class="connectly-edit-page">
    <div class="connectly-edit-container">
        <div class="connectly-edit-header">
            <a href="{{ route('feed') }}" class="connectly-edit-back">
                <i class="bi bi-arrow-left"></i>
                Back to Feed
            </a>
            <h4 class="connectly-edit-title">Edit Post</h4>
        </div>

        <div class="connectly-edit-card">
            <div class="connectly-edit-card-user">
                @if(auth()->user()->avatar_path)
                    <img src="{{ route('media.show', ['path' => auth()->user()->avatar_path]) }}"
                         alt="My avatar"
                         class="connectly-edit-avatar">
                @else
                    <div class="connectly-edit-avatar connectly-edit-avatar-alt">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h6 class="connectly-edit-user-name">{{ auth()->user()->name }}</h6>
                    <span class="connectly-edit-user-label">Editing your post</span>
                </div>
            </div>

            @php
                $postImages = $post->images ?? [];
                $imageCount = count($postImages);
            @endphp

            <form action="{{ route('feed.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="connectly-edit-field">
                    <textarea
                        name="edit_content"
                        class="connectly-edit-textarea @error('edit_content', 'editPost_' . $post->id) is-invalid @enderror"
                        rows="5"
                        placeholder="Update your post..."
                        maxlength="600"
                    >{{ old('edit_content', $post->content) }}</textarea>
                    @error('edit_content', 'editPost_' . $post->id)
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="connectly-edit-charcount">{{ mb_strlen(old('edit_content', $post->content)) }}/600</div>
                </div>

                @if ($imageCount > 0)
                    <div class="connectly-edit-section">
                        <div class="connectly-edit-section-label">
                            <i class="bi bi-images"></i>
                            Current Images
                        </div>
                        <div class="connectly-edit-existing-images">
                            @foreach ($postImages as $imgPath)
                                <div class="connectly-edit-existing-item">
                                    <img src="{{ route('media.show', ['path' => $imgPath]) }}" alt="Post image" loading="lazy">
                                    <label class="connectly-edit-remove-check">
                                        <input type="checkbox" name="remove_images[]" value="{{ $imgPath }}" onchange="this.parentElement.style.opacity=this.checked?'0.6':'1'">
                                        <i class="bi bi-trash"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="connectly-edit-section">
                    <div class="connectly-edit-section-label">
                        <i class="bi bi-cloud-arrow-up"></i>
                        Add More Images
                    </div>
                    <div class="connectly-edit-upload">
                        <input
                            type="file"
                            name="edit_images[]"
                            accept="image/*"
                            multiple
                            class="connectly-edit-upload-input"
                            id="editImageInput"
                            data-preview-container="editPreview"
                        >
                        <label for="editImageInput" class="connectly-edit-upload-label">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span>Click to add more images</span>
                        </label>
                    </div>
                    <div id="editPreview" class="connectly-edit-preview-grid"></div>
                </div>

                <div class="connectly-edit-actions">
                    <a href="{{ route('feed') }}" class="connectly-edit-btn connectly-edit-btn-cancel">Cancel</a>
                    <button type="submit" class="connectly-edit-btn connectly-edit-btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.connectly-edit-page {
    min-height: 100%;
    background: #f5f5f7;
    padding: 2rem 1rem;
}

.connectly-edit-container {
    max-width: 640px;
    margin: 0 auto;
}

.connectly-edit-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.connectly-edit-back {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    text-decoration: none;
    color: #86868b;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 999px;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}

.connectly-edit-back:hover {
    color: #0071e3;
    background: rgba(0,113,227,0.06);
}

.connectly-edit-back i {
    font-size: 0.9rem;
    transition: transform 0.2s ease;
}

.connectly-edit-back:hover i {
    transform: translateX(-2px);
}

.connectly-edit-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1d1d1f;
    margin: 0;
}

.connectly-edit-card {
    background: #ffffff;
    border-radius: 24px;
    border: 1px solid #e5e7eb;
    padding: 1.75rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    animation: editCardSlideUp 0.4s ease-out;
}

@keyframes editCardSlideUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.connectly-edit-card-user {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #f0f0f2;
}

.connectly-edit-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.connectly-edit-avatar-alt {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
    color: #fff;
    background: #0071e3;
}

.connectly-edit-user-name {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1d1d1f;
    margin: 0;
}

.connectly-edit-user-label {
    font-size: 0.8rem;
    color: #86868b;
}

.connectly-edit-field {
    margin-bottom: 1.25rem;
}

.connectly-edit-textarea {
    width: 100%;
    border-radius: 14px;
    border: 1.5px solid #d2d2d7;
    padding: 1rem 1.1rem;
    resize: vertical;
    font-size: 0.9rem;
    background: #f5f5f7;
    color: #1d1d1f;
    transition: border-color 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s cubic-bezier(.4,0,.2,1);
    line-height: 1.6;
    font-family: inherit;
}

.connectly-edit-textarea:focus {
    border-color: #0071e3;
    box-shadow: 0 0 0 3px rgba(0,113,227,0.1);
    background: #ffffff;
    outline: none;
}

.connectly-edit-textarea::placeholder {
    color: #aeaeb2;
}

.connectly-edit-charcount {
    text-align: right;
    font-size: 0.75rem;
    color: #aeaeb2;
    margin-top: 0.35rem;
}

.connectly-edit-section {
    margin-bottom: 1.25rem;
}

.connectly-edit-section-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #86868b;
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.connectly-edit-existing-images {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.connectly-edit-existing-item {
    position: relative;
    width: 96px;
    height: 96px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.connectly-edit-existing-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.connectly-edit-remove-check {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    cursor: pointer;
    transition: opacity 0.2s ease;
    color: #fff;
    font-size: 1rem;
}

.connectly-edit-existing-item:hover .connectly-edit-remove-check {
    opacity: 1;
}

.connectly-edit-remove-check input {
    display: none;
}

.connectly-edit-upload {
    position: relative;
}

.connectly-edit-upload-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.connectly-edit-upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    padding: 0.8rem 1rem;
    border: 1.5px dashed #e5e7eb;
    border-radius: 14px;
    background: #f5f5f7;
    color: #86868b;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
}

.connectly-edit-upload-label:hover {
    border-color: #0071e3;
    background: rgba(0,113,227,0.04);
    color: #0071e3;
}

.connectly-edit-upload-label i {
    font-size: 1.1rem;
}

.connectly-edit-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
    gap: 0.4rem;
    margin-top: 0.5rem;
}

.connectly-edit-preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid #e5e7eb;
    background: #ffffff;
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

.connectly-edit-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1.75rem;
    padding-top: 1.25rem;
    border-top: 1px solid #f0f0f2;
}

.connectly-edit-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 1.5rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
    cursor: pointer;
    text-decoration: none;
    border: none;
    font-family: inherit;
}

.connectly-edit-btn-cancel {
    background: transparent;
    color: #86868b;
    border: 1.5px solid #e5e7eb;
}

.connectly-edit-btn-cancel:hover {
    background: #f5f5f7;
    color: #1d1d1f;
}

.connectly-edit-btn-save {
    background: linear-gradient(135deg, #0071e3, #0058b3);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,113,227,0.2);
}

.connectly-edit-btn-save:hover {
    box-shadow: 0 6px 18px rgba(0,113,227,0.3);
    transform: translateY(-1px);
}

@media (max-width: 640px) {
    .connectly-edit-page {
        padding: 1rem 0.75rem;
    }
    .connectly-edit-card {
        padding: 1.25rem;
        border-radius: 18px;
    }
    .connectly-edit-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .connectly-edit-existing-item {
        width: 80px;
        height: 80px;
    }
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
    if (e.target.matches('.connectly-edit-upload-input')) {
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
