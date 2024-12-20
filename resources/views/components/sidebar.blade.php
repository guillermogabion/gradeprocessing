@php
use Illuminate\Support\Str;
// Check if the current route contains 'organizations' in its name
$isOrganizationRoute = Str::contains(request()->route()->getName(), 'organizations');
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">

            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <!-- Organizations for Admin -->
                @if ($profile && $profile->role == 'super_admin')
                <li class="nav-item {{ request()->routeIs('organizations') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('organizations') }}">
                        <i class="fas fa-users"></i>
                        <p>Organizations</p>
                    </a>
                </li>
                @endif

                <!-- My Organization for Org Admin -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#organizations" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>My Organization</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isOrganizationRoute ? 'show' : '' }}" id="organizations">
                        <ul class="nav nav-collapse">
                            @if ($profile && $profile->role == 'admin')
                            <li class="{{ request()->routeIs('organizations-users') ? 'active' : '' }}">
                                <a href="{{ route('organizations-users') }}">
                                    <span class="sub-item">Users</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('organizations-admin-students') ? 'active' : '' }}">
                                <a href="{{ route('organizations-admin-students') }}">
                                    <span class="sub-item">Students</span>
                                </a>
                            </li>
                            @endif

                            <li class="{{ request()->routeIs('organizations-classrooms') ? 'active' : '' }}">
                                <a href="{{ route('organizations-classrooms') }}">
                                    <span class="sub-item">Class</span>
                                </a>
                            </li>
                            @if ($profile && $profile->role == 'admin')
                            <li class="{{ request()->routeIs('organizations-subject') ? 'active' : '' }}">
                                <a href="{{ route('organizations-subject') }}">
                                    <span class="sub-item">Subject</span>
                                </a>
                            </li>
                            @endif

                            <li>
                                <a href="##">
                                    <span class="sub-item">Documents</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('organizations-rating') ? 'active' : '' }}">
                                <a href="{{ route('organizations-rating') }}">
                                    <span class="sub-item">Rating</span>
                                </a>
                            </li>
                            <!-- Add other sub-items here with the correct routes -->
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#requests" class="nav-link">
                        <i class="fas fa-clipboard-list"></i>
                        <p>Requests</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse " id="requests">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="##">
                                    <span class="sub-item">Leaves</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <span class="sub-item">Overtime</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <span class="sub-item">Undertime</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#documents" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>Documents</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse " id="documents">
                        <ul class="nav nav-collapse">

                            <li>
                                <a href="##">
                                    <span class="sub-item">Class</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <span class="sub-item">Documents</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <span class="sub-item">Rating</span>
                                </a>
                            </li>
                            <!-- Add other sub-items here with the correct routes -->
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>