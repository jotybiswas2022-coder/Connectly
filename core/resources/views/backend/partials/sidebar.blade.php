@php
use Illuminate\Support\Str;
@endphp

<!-- Top Bar -->
<nav class="navbar navbar-expand-lg shadow-sm py-2" style="background: #ffffff;">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center fw-bold fs-5 text-dark" href="/admin" style="padding-left: 12px;">
            <i class="bi bi-speedometer2 me-2 fs-3 text-primary"></i>
            <span style="margin-left: 4px;">Welcome to Admin Dashboard</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Top Nav Links -->
        <div class="collapse navbar-collapse" id="navbarTopNav">
            <ul class="navbar-nav ms-auto gap-3 align-items-center">
                <li class="nav-item">
                    <a class="nav-link top-nav-link {{ request()->is('/') ? 'active-link' : '' }}" href="/">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>

                @auth
                    @if(auth()->user()->is_admin == 1)
                        <li class="nav-item">
                            <a class="nav-link top-nav-link {{ Str::startsWith(request()->path(), 'admin') ? 'active-link' : '' }}" href="/admin">
                                <i class="bi bi-speedometer2 me-1"></i> Admin Panel
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-danger fw-semibold">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link top-nav-link {{ request()->is('login') ? 'active-link' : '' }}" href="/login">
                            <i class="bi bi-person-circle me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link signup-btn px-3 py-1 rounded text-white" href="/register">
                            <i class="bi bi-person-plus me-1"></i> Signup
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar + Content -->
<div class="row m-0" style="min-height: calc(100vh - 64px);">
    <!-- Sidebar -->
    <div class="col-md-3 p-0">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('/admin/account') }}"
                class="{{ request()->is('admin/account') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Account</span>
                </a>
            </li>
             <li>
                <a href="{{ url('/admin/posts') }}"
                class="{{ request()->is('admin/posts') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Posts</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/messages') }}"
                class="{{ request()->is('admin/messages') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/contact') }}"
                class="{{ request()->is('admin/contact') ? 'active' : '' }}">
                    <i class="bi bi-envelope-fill"></i> 
                    <span>Contact</span>
                </a>
            </li>
        </ul>
    </div>
</div>

    <!-- Content -->
    <div class="col-md-9 p-4">
<style>
/* Top navbar */
.navbar .top-nav-link { 
    font-weight:500; 
    color:#343a40; 
    transition: color .3s, transform .3s, border-bottom .3s; 
    position: relative;
}
.navbar .top-nav-link:hover { 
    color:#6366f1; 
    transform:translateY(-1px);
}
.navbar .top-nav-link.active-link::after {
    content:""; 
    display:block; 
    height:2px; 
    background:#6366f1; 
    border-radius:1px;
    position:absolute; 
    bottom:0; 
    left:0; 
    width:100%;
}

/* Brand */
.navbar-brand i { font-size:1.4rem; }

/* Signup button */
.signup-btn { 
    background: linear-gradient(135deg,#6366f1,#8b5cf6); 
    transition: all 0.3s; 
}
.signup-btn:hover { opacity:.9; transform:translateY(-1px); }

/* Sidebar */
.sidebar {
    background: #fefefe;
    min-height: calc(100vh - 64px);
    position: sticky;
    top: 0;
    box-shadow: 4px 0 20px rgba(0,0,0,0.08);
    padding-top: 20px;
    border-right: 1px solid #e3e6f0;
    overflow: hidden;
}
.col-md-9.p-4 {
    max-height: calc(100vh - 64px);
    overflow-y: auto;
}
.row.m-0 {
    min-height: calc(100vh - 64px);
    overflow: hidden;
}
.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar-menu li { margin-bottom: 8px; }
.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #4b4b4b;
    padding: 12px 22px;
    font-weight: 500;
    border-left: 4px solid transparent;
    border-radius: 6px;
    transition: all 0.25s ease;
}
.sidebar-menu a i { font-size: 18px; }
.sidebar-menu a:hover {
    background: rgba(99,102,241,0.1);
    color: #6366f1;
    border-left: 4px solid #6366f1;
}
.sidebar-menu a.active {
    background: rgba(99,102,241,0.15);
    color: #6366f1;
    border-left: 4px solid #6366f1;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .sidebar { min-height: auto; padding-top: 0; position: static; }
    .navbar-nav { text-align: center; }
    .col-md-9.p-4 { max-height: none; overflow: visible; }
    .row.m-0 { min-height: auto; overflow: visible; }
}
</style>