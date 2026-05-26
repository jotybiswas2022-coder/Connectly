@extends('backend.app')

@section('content')

@if (session('success'))
    <input type="hidden" id="sessionSuccess" value="{{ session('success') }}">
@endif

<div class="inbox-page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Inbox</h1>
            <div class="sub">Users' personal messages</div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-pill">
            Total &nbsp;<span>{{ $messages->total() ?? 0 }}</span>
        </div>
        <div class="stat-pill">
            Page &nbsp;<span>{{ $messages->currentPage() ?? 1 }}</span> of 
            <span>{{ $messages->lastPage() ?? 1 }}</span>
        </div>
    </div>

    {{-- Card --}}
    <div class="inbox-card">
        <div class="card-toolbar">
            <form method="GET" action="" class="search-wrap">
                <input id="messagesSearch" name="search" type="search"
                       placeholder="Search by sender…"
                       value="{{ request('search') }}"
                       autocomplete="off">
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>

        <div class="table-scroll-top" aria-hidden="true">
            <div class="table-scroll-top-inner"></div>
        </div>

        <div class="table-wrap" id="messageTableWrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Message</th>
                        <th>Received</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($messages as $message)

                @php
                    $senderName = optional($message->sender)->name ?? '—';
                    $receiverName = optional($message->recipient)->name ?? '—';

                    $senderInitial = strtoupper(substr($senderName,0,1));
                    $receiverInitial = strtoupper(substr($receiverName,0,1));
                @endphp

                <tr>
                    <td>
                        <span class="idx">
                            {{ $loop->iteration + ($messages->perPage() * ($messages->currentPage() - 1)) }}
                        </span>
                    </td>

                    {{-- Sender --}}
                    <td>
                        <div class="user-cell">
                            <div class="avatar av-blue">{{ $senderInitial }}</div>
                            <div>
                                <div class="user-name">{{ $senderName }}</div>
                                <div class="user-email">
                                    {{ optional($message->sender)->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Receiver --}}
                    <td>
                        <div class="user-cell">
                            <div class="avatar av-teal">{{ $receiverInitial }}</div>
                            <div>
                                <div class="user-name">{{ $receiverName }}</div>
                                <div class="user-email">
                                    {{ optional($message->recipient)->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Message --}}
                    <td>
                        <div class="msg-preview">
                            <span class="msg-text">
                                {{ Str::limit($message->message, 80) }}
                            </span>
                        </div>
                    </td>

                    {{-- Time --}}
                    <td>
                        <span class="time-badge">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions">

                            {{-- View --}}
                            <button type="button" class="btn-icon btn-view-message"
                                data-sender="{{ $senderName }}"
                                data-recipient="{{ $receiverName }}"
                                data-email="{{ optional($message->sender)->email }}"
                                data-message="{{ $message->message }}"
                                data-image="{{ $message->image ?? '' }}"
                                data-created="{{ $message->created_at->format('D, M j, Y h:i A') }}"
                                title="View">
                                👁
                            </button>

                            {{-- Edit --}}
                            <button type="button" class="btn-icon edit btn-edit-message"
                                data-action="{{ route('messages.update', $message->id) }}"
                                data-message="{{ $message->message }}"
                                title="Edit">
                                ✏️
                            </button>

                            {{-- Delete --}}
                            <form method="POST"
                                  action="{{ route('messages.destroy', $message->id) }}"
                                  class="d-inline-block delete-form"
                                  data-title="Delete Message?"
                                  data-text="This action cannot be undone.">

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
                    <td colspan="6" style="text-align:center;padding:20px;">
                        No messages found
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="table-footer">
            <div>
                Showing <strong>{{ $messages->count() }}</strong>
                of <strong>{{ $messages->total() }}</strong>
            </div>

            <div>
                {{ $messages->links() }}
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            timerProgressBar: true,
            background: '#ecfdf5',
            color: '#065f46',
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
                background: '#fff',
                backdrop: 'rgba(0,0,0,0.4)',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    f.submit();
                }
            });
        });
    });

    // View modal
    document.querySelectorAll('.btn-view-message').forEach(function(btn){
        btn.addEventListener('click', function(){
            document.getElementById('m-sender').textContent    = this.dataset.sender    || '—';
            document.getElementById('m-recipient').textContent = this.dataset.recipient || '—';
            document.getElementById('m-email').textContent     = this.dataset.email     || '—';
            document.getElementById('m-created').textContent   = this.dataset.created   || '—';

            var imgBox = document.getElementById('m-image');
            var imgUrl = this.dataset.image || '';
            if (imgUrl) {
                imgBox.style.display = 'block';
                imgBox.innerHTML = '<img src="'+imgUrl+'" class="img-fluid rounded" style="max-height:280px;border:1px solid var(--border);border-radius:10px;">';
            } else {
                imgBox.style.display = 'none';
                imgBox.innerHTML = '';
            }
            document.getElementById('m-body').innerHTML = (this.dataset.message || '').replace(/\n/g,'<br>') || '—';
            new bootstrap.Modal(document.getElementById('messageModal')).show();
        });
    });

    // Edit modal
    document.querySelectorAll('.btn-edit-message').forEach(function(btn){
        btn.addEventListener('click', function(){
            document.getElementById('editMessageForm').action = this.dataset.action;
            document.getElementById('editMessageText').value  = this.dataset.message || '';
            new bootstrap.Modal(document.getElementById('editMessageModal')).show();
        });
    });

    // Synchronized top scrollbar for the table
    var topScroll = document.querySelector('.table-scroll-top');
    var tableWrap = document.getElementById('messageTableWrap');
    var topScrollInner = topScroll ? topScroll.querySelector('.table-scroll-top-inner') : null;
    var tableElement = tableWrap ? tableWrap.querySelector('table') : null;

    function refreshTopScroll() {
        if (!topScroll || !tableWrap || !topScrollInner || !tableElement) return;
        topScrollInner.style.width = tableElement.scrollWidth + 'px';
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

    // No automatic reload on pause; user submits search explicitly.
});
</script>

<!-- Message View Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:8px;vertical-align:middle;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          Message Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding:22px;">
        <div class="detail-grid">
          <span class="detail-label">From</span>
          <span class="detail-value" id="m-sender">—</span>
          <span class="detail-label">To</span>
          <span class="detail-value" id="m-recipient">—</span>
          <span class="detail-label">Email</span>
          <span class="detail-value" id="m-email">—</span>
          <span class="detail-label">Received</span>
          <span class="detail-value" id="m-created" style="font-family:var(--mono);font-size:.8rem;">—</span>
          <hr class="detail-divider">
          <div id="m-image" class="detail-grid" style="display:none;grid-column:1/-1;text-align:center;margin-bottom:4px;"></div>
          <div class="msg-body-block" id="m-body">—</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Message Edit Modal -->
<div class="modal fade" id="editMessageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editMessageForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:8px;vertical-align:middle;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Message
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding:22px;">
          <label for="editMessageText" class="form-label">Message text</label>
          <textarea id="editMessageText" name="message" class="form-control" rows="5" maxlength="1000"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-primary-custom">Update Message</button>
        </div>
      </form>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --primary-bg: #eef2ff;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --warning: #f59e0b;
            --info: #06b6d4;
            --info-bg: #ecfeff;
            --edit: #f59e0b;
            --edit-bg: #fffbeb;
            --bg: #f1f5f9;
            --card: #ffffff;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --text: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --mono: 'JetBrains Mono', monospace;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --shadow-sm: 0 1px 2px rgba(0,0,0,.04);
            --shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,.07), 0 2px 4px -2px rgba(0,0,0,.05);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.08), 0 4px 6px -4px rgba(0,0,0,.04);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,.08), 0 8px 10px -6px rgba(0,0,0,.04);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-xs: 6px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

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

        /* ── Inbox Page ── */
        .inbox-page {
            max-width: 1320px;
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
        .stat-pill svg {
            color: var(--primary);
            flex-shrink: 0;
        }
        .stat-pill span {
            font-weight: 700;
            color: var(--text);
            font-family: var(--mono);
            font-size: .8rem;
        }

        /* ── Inbox Card ── */
        .inbox-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        /* ── Card Toolbar ── */
        .card-toolbar {
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-light);
            background: linear-gradient(180deg, #fafbfc 0%, var(--card) 100%);
        }
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 0;
            background: var(--bg);
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
            background: #fff;
        }
        .search-wrap svg {
            flex-shrink: 0;
            color: var(--text-muted);
            transition: color .2s;
        }
        .search-wrap:focus-within svg { color: var(--primary); }
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
            background: linear-gradient(180deg, #f8fafc, #f1f5f9);
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
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
            user-select: none;
        }
        tbody tr {
            border-bottom: 1px solid var(--border-light);
            transition: background .15s;
        }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child { border-bottom: none; }
        tbody td {
            padding: 14px 18px;
            vertical-align: middle;
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
        .av-teal {
            background: linear-gradient(135deg, #14b8a6, #2dd4bf);
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

        /* ── Message Preview ── */
        .msg-preview {
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 340px;
        }
        .msg-preview img {
            width: 36px; height: 36px;
            object-fit: cover;
            border-radius: var(--radius-xs);
            border: 1.5px solid var(--border);
            flex-shrink: 0;
        }
        .msg-text {
            color: var(--text-secondary);
            font-size: .82rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ── Time Badge ── */
        .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: var(--bg);
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
            background: linear-gradient(180deg, var(--card) 0%, #fafbfc 100%);
            flex-wrap: wrap;
            gap: 12px;
        }
        .table-footer strong {
            color: var(--text);
            font-weight: 600;
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            margin: 0; padding: 0;
        }
        .pagination .page-item .page-link {
            display: grid;
            place-items: center;
            min-width: 34px; height: 34px;
            padding: 0 10px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-xs);
            font-size: .78rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            background: var(--card);
            transition: all .2s;
            font-family: var(--font);
        }
        .pagination .page-item .page-link:hover {
            background: var(--primary-bg);
            border-color: var(--primary-light);
            color: var(--primary);
        }
        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(99,102,241,.3);
        }
        .pagination .page-item.disabled .page-link {
            opacity: .4;
            pointer-events: none;
        }

        /* ── Empty State ── */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 64px 24px;
            color: var(--text-muted);
        }
        .empty-state svg {
            margin-bottom: 16px;
            color: var(--border);
        }
        .empty-state p {
            font-size: .9rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* ── Modal Overrides ── */
        .modal-content {
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-light);
            background: linear-gradient(180deg, #fafbfc, var(--card));
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
            background: #fafbfc;
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
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 18px 20px;
            font-size: .85rem;
            line-height: 1.75;
            color: var(--text);
            margin-top: 4px;
            word-break: break-word;
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
            box-shadow: 0 2px 8px rgba(99,102,241,.25);
            font-family: var(--font);
        }
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, var(--primary-dark), #4338ca);
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
        @media (max-width: 768px) {
            .inbox-page { padding: 20px 14px 36px; }
            .page-header h1 { font-size: 1.35rem; }
            .page-header h1::before { height: 22px; }
            .card-toolbar { padding: 14px 16px; }
            .search-wrap { max-width: 100%; }
            thead th, tbody td { padding: 12px 12px; }
            .user-cell { gap: 8px; }
            .avatar { width: 32px; height: 32px; font-size: .7rem; border-radius: 8px; }
            .msg-preview { max-width: 200px; }
            .table-footer { flex-direction: column; align-items: flex-start; padding: 14px 16px; }
            .stats-strip { gap: 8px; }
            .stat-pill { padding: 8px 14px; font-size: .75rem; }
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
    </style>

@endsection
