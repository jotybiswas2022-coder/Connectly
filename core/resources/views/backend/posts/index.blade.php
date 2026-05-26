@extends('backend.app')

@section('content')

@if (session('success'))
    <input type="hidden" id="sessionSuccess" value="{{ session('success') }}">
@endif

<div class="posts-page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Posts</h1>
            <div class="sub">Manage all user posts</div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-pill">
            Total &nbsp;<span>{{ $posts->total() ?? 0 }}</span>
        </div>
        <div class="stat-pill">
            Page &nbsp;<span>{{ $posts->currentPage() ?? 1 }}</span> of
            <span>{{ $posts->lastPage() ?? 1 }}</span>
        </div>
        @php
            $totalReactions = $posts->sum('reactions_count');
            $totalComments = $posts->sum('comments_count');
        @endphp
        <div class="stat-pill">
            💬 &nbsp;<span>{{ $totalComments }}</span>
        </div>
        <div class="stat-pill">
            ❤️ &nbsp;<span>{{ $totalReactions }}</span>
        </div>
    </div>

    {{-- Card --}}
    <div class="posts-card">
        <div class="card-toolbar">
            <form method="GET" action="" class="search-wrap">
                <input id="postsSearch" name="search" type="search"
                       placeholder="Search by content or author…"
                       value="{{ request('search') }}"
                       autocomplete="off">
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>

        <div class="table-scroll-top" aria-hidden="true">
            <div class="table-scroll-top-inner"></div>
        </div>

        <div class="table-wrap" id="postTableWrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Author</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Stats</th>
                        <th>Created</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($posts as $post)

                @php
                    $authorName = optional($post->user)->name ?? '—';
                    $authorInitial = strtoupper(substr($authorName, 0, 1));
                    $contentPreview = strip_tags($post->content ?? '');
                    $hasImage = !empty($post->image_path);
                @endphp

                <tr class="{{ $post->is_pinned ? 'pinned-row' : '' }}">
                    <td>
                        <span class="idx">
                            {{ $loop->iteration + ($posts->perPage() * ($posts->currentPage() - 1)) }}
                        </span>
                    </td>

                    {{-- Author --}}
                    <td>
                        <div class="user-cell">
                            <div class="avatar av-blue">{{ $authorInitial }}</div>
                            <div>
                                <div class="user-name">{{ $authorName }}</div>
                                <div class="user-email">
                                    {{ optional($post->user)->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Content --}}
                    <td>
                        <div class="content-preview">
                            <span class="content-text">
                                {{ Str::limit($contentPreview, 80) }}
                            </span>
                        </div>
                    </td>

                    {{-- Image --}}
                    <td>
                        @if($hasImage)
                            <img src="{{ config('app.storage_url') }}{{ $post->image_path }}"
                                 alt="Post image"
                                 class="post-thumb"
                                 loading="lazy">
                        @else
                            <span class="no-img">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($post->is_pinned)
                            <span class="status-badge pinned">📌 Pinned</span>
                        @else
                            <span class="status-badge normal">Normal</span>
                        @endif
                    </td>

                    {{-- Stats --}}
                    <td>
                        <div class="stats-cell">
                            <span class="stat-item" title="Reactions">
                                ❤️ {{ $post->reactions_count ?? 0 }}
                            </span>
                            <span class="stat-item" title="Comments">
                                💬 {{ $post->comments_count ?? 0 }}
                            </span>
                        </div>
                    </td>

                    {{-- Time --}}
                    <td>
                        <span class="time-badge">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions">

                            {{-- View --}}
                            <button type="button" class="btn-icon btn-view-post"
                                data-author="{{ $authorName }}"
                                data-email="{{ optional($post->user)->email }}"
                                data-content="{{ $post->content }}"
                                data-image="{{ $post->image_path ? config('app.storage_url') . $post->image_path : '' }}"
                                data-pinned="{{ $post->is_pinned ? 'true' : 'false' }}"
                                data-reactions="{{ $post->reactions_count ?? 0 }}"
                                data-comments="{{ $post->comments_count ?? 0 }}"
                                data-created="{{ $post->created_at->format('D, M j, Y h:i A') }}"
                                data-updated="{{ $post->updated_at->format('D, M j, Y h:i A') }}"
                                title="View">
                                👁
                            </button>

                            {{-- Edit --}}
                            <button type="button" class="btn-icon edit btn-edit-post"
                                data-action="{{ route('posts.update', $post) }}"
                                data-content="{{ $post->content }}"
                                data-pinned="{{ $post->is_pinned ? 'true' : 'false' }}"
                                title="Edit">
                                ✏️
                            </button>

                            {{-- Delete --}}
                            <form method="POST"
                                  action="{{ route('posts.destroy', $post) }}"
                                  class="d-inline-block delete-form"
                                  data-title="Delete Post?"
                                  data-text="All comments and reactions will also be removed. This cannot be undone.">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-icon del" title="Delete">
                                    🗑
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px 20px;">
                        <div class="empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <p>No posts found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="table-footer">
            <div>
                Showing <strong>{{ $posts->count() }}</strong>
                of <strong>{{ $posts->total() }}</strong>
            </div>

            <div>
                {{ $posts->links() }}
            </div>
        </div>

    </div>
</div>

{{-- ===== View Post Modal ===== --}}
<div class="modal fade" id="viewPostModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:8px;vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          Post Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding:22px;">
        <div class="detail-grid">
          <span class="detail-label">Author</span>
          <span class="detail-value" id="vp-author">—</span>
          <span class="detail-label">Email</span>
          <span class="detail-value" id="vp-email">—</span>
          <span class="detail-label">Status</span>
          <span class="detail-value" id="vp-status">—</span>
          <span class="detail-label">Created</span>
          <span class="detail-value" id="vp-created" style="font-family:var(--mono);font-size:.8rem;">—</span>
          <span class="detail-label">Updated</span>
          <span class="detail-value" id="vp-updated" style="font-family:var(--mono);font-size:.8rem;">—</span>
          <span class="detail-label">Stats</span>
          <span class="detail-value" id="vp-stats">—</span>
          <hr class="detail-divider">
          <div id="vp-image" class="detail-grid" style="display:none;grid-column:1/-1;text-align:center;margin-bottom:4px;"></div>
          <div class="msg-body-block" id="vp-content">—</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- ===== Edit Post Modal ===== --}}
<div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editPostForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:8px;vertical-align:middle;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Post
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding:22px;">
          <label for="editPostContent" class="form-label">Content</label>
          <textarea id="editPostContent" name="content" class="form-control" rows="6" maxlength="10000"></textarea>

          <div class="edit-pinned-wrap">
            <label class="pinned-toggle">
              <input type="checkbox" name="is_pinned" value="1" id="editPostPinned">
              <span class="toggle-track">
                <span class="toggle-knob"></span>
              </span>
              <span class="toggle-label">📌 Pin this post</span>
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-primary-custom">Update Post</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
    :root {
        --primary: #2563EB;
        --primary-light: #60A5FA;
        --primary-dark: #1E40AF;
        --primary-bg: rgba(37,99,235,0.12);
        --success: #10b981;
        --success-bg: rgba(16,185,129,0.12);
        --danger: #ef4444;
        --danger-bg: rgba(239,68,68,0.12);
        --warning: #f59e0b;
        --info: #06b6d4;
        --info-bg: rgba(6,182,212,0.12);
        --edit: #f59e0b;
        --edit-bg: rgba(245,158,11,0.12);
        --pin: #a78bfa;
        --pin-bg: rgba(139,92,246,0.12);
        --bg: #0f172a;
        --card: rgba(255,255,255,0.04);
        --border: rgba(255,255,255,0.08);
        --border-light: rgba(255,255,255,0.04);
        --text: #f1f5f9;
        --text-secondary: #94a3b8;
        --text-muted: #64748b;
        --mono: 'JetBrains Mono', monospace;
        --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        --shadow-sm: 0 1px 2px rgba(0,0,0,.1);
        --shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.1);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,.15), 0 2px 4px -2px rgba(0,0,0,.12);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.2), 0 4px 6px -4px rgba(0,0,0,.15);
        --shadow-xl: 0 20px 25px -5px rgba(0,0,0,.25), 0 8px 10px -6px rgba(0,0,0,.2);
        --radius: 12px;
        --radius-sm: 8px;
        --radius-xs: 6px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    /* ── Toast ── */
    .alert-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border-radius: var(--radius);
        box-shadow: 0 10px 40px rgba(16, 185, 129, .3);
        font-size: .875rem;
        font-weight: 500;
        animation: toastSlide .5s cubic-bezier(.16,1,.3,1);
        backdrop-filter: blur(10px);
    }
    @keyframes toastSlide {
        from { opacity: 0; transform: translateX(40px) scale(.96); }
        to   { opacity: 1; transform: translateX(0) scale(1); }
    }
    .toast-icon {
        width: 24px; height: 24px;
        background: rgba(255,255,255,.25);
        border-radius: 50%;
        display: grid; place-items: center;
        font-weight: 700; font-size: .8rem;
        flex-shrink: 0;
    }
    .toast-close {
        background: rgba(255,255,255,.2);
        border: none; color: #fff;
        width: 22px; height: 22px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1rem;
        display: grid; place-items: center;
        margin-left: 4px;
        transition: background .2s;
    }
    .toast-close:hover { background: rgba(255,255,255,.35); }

    /* ── Posts Page ── */
    .posts-page {
        max-width: 1360px;
        margin: 0 auto;
        padding: 32px 28px 48px;
    }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -.02em;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .page-header h1::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 28px;
        background: linear-gradient(180deg, var(--primary), var(--primary-light));
        border-radius: 4px;
    }
    .page-header .sub {
        font-size: .875rem;
        color: var(--text-secondary);
        margin-top: 4px;
        padding-left: 16px;
    }

    /* ── Stats Strip ── */
    .stats-strip {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 500;
        color: var(--text-secondary);
        box-shadow: var(--shadow-sm);
        transition: all .2s;
    }
    .stat-pill:hover {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px var(--primary-bg);
    }
    .stat-pill span {
        font-weight: 700;
        color: var(--text);
        font-family: var(--mono);
        font-size: .8rem;
    }

    /* ── Card Toolbar ── */
    .card-toolbar {
        padding: 18px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(180deg, rgba(255,255,255,0.06) 0%, transparent 100%);
        border-bottom: 1px solid var(--border-light);
    }
    .search-wrap {
        display: flex;
        align-items: center;
        gap: 0;
        background: rgba(0,0,0,0.25);
        border: 1.5px solid var(--border);
        border-radius: 50px;
        padding: 0 4px 0 16px;
        width: 100%;
        max-width: 420px;
        transition: all .25s;
    }
    .search-wrap:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-bg);
        background: rgba(0,0,0,0.35);
    }
    .search-wrap input {
        border: none;
        background: transparent;
        padding: 10px 12px;
        font-size: .85rem;
        color: var(--text);
        width: 100%;
        outline: none;
        font-family: var(--font);
    }
    .search-wrap input::placeholder { color: var(--text-muted); }
    .search-button {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        white-space: nowrap;
        font-family: var(--font);
    }
    .search-button:hover { background: var(--primary-dark); transform: translateY(-1px); }

    /* ── Table ── */
    .posts-card {
        background: var(--card);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .table-scroll-top {
        overflow-x: auto;
        overflow-y: hidden;
        height: 12px;
        margin-bottom: 12px;
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }
    .table-scroll-top-inner {
        height: 1px;
        min-width: 100%;
    }
    .table-scroll-top::-webkit-scrollbar {
        height: 8px;
    }
    .table-scroll-top::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 999px;
    }
    .table-wrap {
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: .85rem;
    }
    thead {
        background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
        position: sticky;
        top: 0;
        z-index: 2;
    }
    thead th {
        padding: 13px 18px;
        text-align: left;
        font-weight: 600;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
        user-select: none;
    }
    tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background .15s;
    }
    tbody tr:hover { background: rgba(255,255,255,0.04); }
    tbody tr:last-child { border-bottom: none; }
    tbody td {
        padding: 14px 18px;
        vertical-align: middle;
    }

    /* Pinned row highlight */
    .pinned-row {
        background: linear-gradient(90deg, var(--pin-bg) 0%, transparent 40%);
    }
    .pinned-row:hover {
        background: linear-gradient(90deg, rgba(139,92,246,0.18) 0%, rgba(255,255,255,0.04) 40%);
    }

    /* ── Index Number ── */
    .idx {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px; height: 30px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-xs);
        font-weight: 600;
        font-size: .75rem;
        color: var(--text-secondary);
        font-family: var(--mono);
    }

    /* ── User Cell ── */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: grid; place-items: center;
        font-weight: 700;
        font-size: .8rem;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: .02em;
        box-shadow: var(--shadow-sm);
    }
    .av-blue {
        background: linear-gradient(135deg, #6366f1, #818cf8);
    }
    .user-name {
        font-weight: 600;
        font-size: .84rem;
        color: var(--text);
        line-height: 1.3;
    }
    .user-email {
        font-size: .75rem;
        color: var(--text-muted);
        margin-top: 1px;
    }

    /* ── Content Preview ── */
    .content-preview {
        max-width: 320px;
    }
    .content-text {
        color: var(--text-secondary);
        font-size: .82rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
    }

    /* ── Post Thumbnail ── */
    .post-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: var(--radius-xs);
        border: 1.5px solid var(--border);
        transition: transform .2s, box-shadow .2s;
        cursor: pointer;
    }
    .post-thumb:hover {
        transform: scale(1.8);
        box-shadow: var(--shadow-lg);
        z-index: 10;
        position: relative;
    }
    .no-img {
        color: var(--text-muted);
        font-size: .8rem;
    }

    /* ── Status Badge ── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-badge.pinned {
        background: var(--pin-bg);
        color: var(--pin);
        border: 1px solid #ddd6fe;
    }
    .status-badge.normal {
        background: var(--bg);
        color: var(--text-muted);
        border: 1px solid var(--border);
    }

    /* ── Stats Cell ── */
    .stats-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .stat-item {
        font-size: .78rem;
        font-weight: 500;
        color: var(--text-secondary);
        white-space: nowrap;
    }

    /* ── Time Badge ── */
    .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: rgba(0,0,0,0.2);
        border: 1px solid var(--border);
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 500;
        color: var(--text-secondary);
        font-family: var(--mono);
        white-space: nowrap;
    }

    /* ── Actions ── */
    .actions {
        display: flex;
        align-items: center;
        gap: 6px;
        justify-content: flex-end;
    }
    .btn-icon {
        width: 34px; height: 34px;
        border: 1.5px solid var(--border);
        background: var(--card);
        border-radius: var(--radius-xs);
        display: grid; place-items: center;
        cursor: pointer;
        color: var(--text-secondary);
        transition: all .2s;
    }
    .btn-icon:hover {
        background: var(--primary-bg);
        border-color: var(--primary-light);
        color: var(--primary);
        transform: translateY(-1px);
        box-shadow: var(--shadow);
    }
    .btn-icon.edit:hover {
        background: var(--edit-bg);
        border-color: var(--edit);
        color: var(--edit);
    }
    .btn-icon.del:hover {
        background: var(--danger-bg);
        border-color: var(--danger);
        color: var(--danger);
    }
    .d-inline-block { display: inline-block; }

    /* ── Table Footer ── */
    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 22px;
        border-top: 1px solid var(--border-light);
        font-size: .8rem;
        color: var(--text-secondary);
        background: linear-gradient(180deg, transparent 0%, rgba(255,255,255,0.02) 100%);
        flex-wrap: wrap;
        gap: 12px;
    }
    .table-footer strong {
        color: var(--text);
        font-weight: 600;
    }

    .table-footer .pagination .page-item .page-link {
        background: rgba(255,255,255,0.04);
        border-color: var(--border);
        color: var(--text-secondary);
    }
    .table-footer .pagination .page-item .page-link:hover {
        background: var(--primary-bg);
        border-color: rgba(37,99,235,0.2);
        color: var(--primary-light);
    }
    .table-footer .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        border-color: #2563EB;
        color: #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,0.3);
    }

    /* ── Pagination ── */
    .pagination {
        display: flex;
        gap: 4px;
        list-style: none;
        margin: 0; padding: 0;
    }
    .pagination .page-item.disabled .page-link {
        opacity: .3;
        pointer-events: none;
    }

    /* ── Empty State ── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 32px 24px;
        color: var(--text-muted);
    }
    .empty-state svg {
        margin-bottom: 16px;
        color: rgba(255,255,255,0.08);
    }
    .empty-state p {
        font-size: .9rem;
        font-weight: 500;
        color: var(--text-secondary);
    }

    /* ── Edit Pinned Toggle ── */
    .edit-pinned-wrap {
        margin-top: 18px;
    }
    .pinned-toggle {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
    }
    .pinned-toggle input[type="checkbox"] {
        display: none;
    }
    .toggle-track {
        position: relative;
        width: 44px;
        height: 24px;
        background: var(--border);
        border-radius: 50px;
        transition: background .25s;
        flex-shrink: 0;
    }
    .toggle-knob {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 18px;
        height: 18px;
        background: #fff;
        border-radius: 50%;
        box-shadow: var(--shadow-sm);
        transition: transform .25s cubic-bezier(.34,1.56,.64,1);
    }
    .pinned-toggle input:checked + .toggle-track {
        background: var(--pin);
    }
    .pinned-toggle input:checked + .toggle-track .toggle-knob {
        transform: translateX(20px);
    }
    .toggle-label {
        font-size: .82rem;
        font-weight: 500;
        color: var(--text-secondary);
    }

    /* ── Modal Overrides ── */
    .modal-content {
        background: #1e293b;
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
    }
    .modal-content .form-control {
        background: rgba(0,0,0,0.2);
        color: var(--text);
    }
    .modal-content .form-control::placeholder {
        color: var(--text-muted);
    }
    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-light);
        background: linear-gradient(180deg, rgba(255,255,255,0.06), transparent);
    }
    .modal-title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
    }
    .modal-title svg { color: var(--primary); }
    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border-light);
        background: rgba(0,0,0,0.15);
        gap: 10px;
    }
    .modal-body .form-label {
        font-size: .8rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 8px;
    }
    .modal-body .form-control {
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: .85rem;
        padding: 12px 16px;
        transition: all .2s;
        font-family: var(--font);
        resize: vertical;
    }
    .modal-body .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-bg);
    }

    /* ── Detail Grid (View Modal) ── */
    .detail-grid {
        display: grid;
        grid-template-columns: 90px 1fr;
        gap: 10px 16px;
        align-items: start;
    }
    .detail-label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--text-muted);
        padding-top: 2px;
    }
    .detail-value {
        font-size: .85rem;
        font-weight: 500;
        color: var(--text);
    }
    .detail-divider {
        grid-column: 1 / -1;
        border: none;
        border-top: 1px solid var(--border-light);
        margin: 6px 0;
    }
    .msg-body-block {
        grid-column: 1 / -1;
        background: rgba(0,0,0,0.2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 18px 20px;
        font-size: .85rem;
        line-height: 1.75;
        color: var(--text);
        margin-top: 4px;
        word-break: break-word;
        white-space: pre-wrap;
    }

    /* ── Custom Buttons ── */
    .btn-secondary-custom {
        padding: 9px 20px;
        border: 1.5px solid var(--border);
        background: var(--card);
        border-radius: var(--radius-sm);
        font-size: .82rem;
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all .2s;
        font-family: var(--font);
    }
    .btn-secondary-custom:hover {
        background: var(--bg);
        border-color: var(--text-muted);
    }
    .btn-primary-custom {
        padding: 9px 24px;
        border: none;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-sm);
        font-size: .82rem;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 2px 8px rgba(37,99,235,.25);
        font-family: var(--font);
    }
    .btn-primary-custom:hover {
        background: linear-gradient(135deg, var(--primary-dark), #1e3a8a);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99,102,241,.35);
    }

    .btn-close {
        width: 30px; height: 30px;
        border-radius: 8px;
        opacity: .5;
        transition: all .2s;
    }
    .btn-close:hover { opacity: 1; background-color: var(--danger-bg); }

    /* ── Responsive ── */
    @media (max-width: 992px) {
        .posts-page { padding: 24px 18px 40px; }
        .search-wrap { max-width: 320px; }
        .user-email { display: none; }
        thead th, tbody td { padding: 12px 14px; }
        .content-preview { max-width: 240px; }
    }
    @media (max-width: 768px) {
        .posts-page { padding: 20px 14px 36px; }
        .page-header h1 { font-size: 1.35rem; }
        .page-header h1::before { height: 22px; }
        .page-header { flex-direction: column; gap: 12px; }
        .card-toolbar { padding: 14px 16px; flex-wrap: wrap; gap: 10px; }
        .search-wrap { max-width: 100%; }
        thead th, tbody td { padding: 10px 10px; }
        .user-cell { gap: 8px; }
        .avatar { width: 30px; height: 30px; font-size: .65rem; border-radius: 7px; }
        .content-preview { max-width: 140px; }
        .post-thumb { width: 32px; height: 32px; }
        .stats-cell { gap: 6px; }
        .table-footer { flex-direction: column; align-items: flex-start; padding: 14px 16px; }
        .stats-strip { gap: 8px; }
        .stat-pill { padding: 8px 14px; font-size: .75rem; }
        .detail-grid { grid-template-columns: 1fr; gap: 4px 0; }
        .detail-label { padding-top: 8px; }
        .btn-icon { width: 38px; height: 38px; } /* bigger touch target */
    }
    @media (max-width: 480px) {
        .posts-page { padding: 14px 10px 28px; }
        .page-header h1 { font-size: 1.15rem; }
        .stat-pill { padding: 6px 10px; font-size: .7rem; }
        thead th { font-size: .65rem; padding: 8px 6px; }
        tbody td { padding: 8px 6px; }
        thead th:nth-child(6), tbody td:nth-child(6) { display: none; } /* hide stats on tiny */
        thead th:nth-child(5), tbody td:nth-child(5) { display: none; } /* hide status on tiny */
        .content-preview { max-width: 120px; }
        .btn-icon { width: 36px; height: 36px; }
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // SweetAlert2 — Success Toast
        var sessionSuccess = document.getElementById('sessionSuccess');
        if (sessionSuccess) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: sessionSuccess.value,
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,                    background: '#1e293b',
                    color: '#4ade80',
                iconColor: '#10b981',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        // SweetAlert2 — Delete confirmation
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var f = this;
                Swal.fire({
                    title: f.dataset.title || 'Are you sure?',
                    text: f.dataset.text || 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    background: '#1e293b',
                    backdrop: 'rgba(0,0,0,0.7)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        f.submit();
                    }
                });
            });
        });

        // View post modal
        document.querySelectorAll('.btn-view-post').forEach(function(btn){
            btn.addEventListener('click', function(){
                document.getElementById('vp-author').textContent = this.dataset.author || '—';
                document.getElementById('vp-email').textContent = this.dataset.email || '—';

                var isPinned = this.dataset.pinned === 'true';
                document.getElementById('vp-status').innerHTML = isPinned
                    ? '<span class="status-badge pinned" style="font-size:.82rem;">📌 Pinned</span>'
                    : '<span class="status-badge normal" style="font-size:.82rem;">Normal</span>';

                document.getElementById('vp-created').textContent = this.dataset.created || '—';
                document.getElementById('vp-updated').textContent = this.dataset.updated || '—';
                document.getElementById('vp-stats').innerHTML = '❤️ ' + (this.dataset.reactions || '0') + ' &nbsp; 💬 ' + (this.dataset.comments || '0');                var imgBox = document.getElementById('vp-image');
                    var imgUrl = this.dataset.image || '';
                    if (imgUrl) {
                        imgBox.style.display = 'block';
                        imgBox.innerHTML = '<img src="' + imgUrl + '" class="img-fluid rounded" style="max-height:320px;border:1px solid var(--border);border-radius:10px;">';
                    } else {
                        imgBox.style.display = 'none';
                        imgBox.innerHTML = '';
                    }
                document.getElementById('vp-content').innerHTML = (this.dataset.content || '').replace(/\n/g,'<br>') || '—';

                var modal = new bootstrap.Modal(document.getElementById('viewPostModal'));
                modal.show();
            });
        });

        // Edit post modal
        document.querySelectorAll('.btn-edit-post').forEach(function(btn){
            btn.addEventListener('click', function(){
                document.getElementById('editPostForm').action = this.dataset.action;
                document.getElementById('editPostContent').value = this.dataset.content || '';
                document.getElementById('editPostPinned').checked = this.dataset.pinned === 'true';

                var modal = new bootstrap.Modal(document.getElementById('editPostModal'));
                modal.show();
            });
        });

        // Synchronized top scrollbar for the table
        var topScroll = document.querySelector('.table-scroll-top');
        var tableWrap = document.getElementById('postTableWrap');
        var topScrollInner = topScroll ? topScroll.querySelector('.table-scroll-top-inner') : null;

        function refreshTopScroll() {
            if (!topScroll || !tableWrap || !topScrollInner) return;
            topScrollInner.style.width = tableWrap.querySelector('table').scrollWidth + 'px';
        }

        if (topScroll && tableWrap) {
            refreshTopScroll();
            tableWrap.addEventListener('scroll', function() {
                topScroll.scrollLeft = tableWrap.scrollLeft;
            });
            topScroll.addEventListener('scroll', function() {
                tableWrap.scrollLeft = topScroll.scrollLeft;
            });
            window.addEventListener('resize', refreshTopScroll);
        }
    });
</script>

@endsection
