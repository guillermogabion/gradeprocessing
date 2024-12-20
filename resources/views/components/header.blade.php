<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img
                    src="{{ $organization ? asset('orgImage/' . $organization->orgImage) : 'https://via.placeholder.com/100/CCCCCC/FFFFFF' }}" alt="Image Preview" style="display: block; width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd; padding: 5px; cursor: pointer;" onclick="document.getElementById('orgImage').click();"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20" />
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
    <!-- Navbar Header -->
    <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">


            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                    class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    <a
                        class="nav-link dropdown-toggle"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-expanded="false"
                        aria-haspopup="true">
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        <form class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input
                                    type="text"
                                    placeholder="Search ..."
                                    class="form-control" />
                            </div>
                        </form>
                    </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="messageDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                    </a>
                    <ul
                        class="dropdown-menu messages-notif-box animated fadeIn"
                        aria-labelledby="messageDropdown">
                        <li>
                            <div
                                class="dropdown-title d-flex justify-content-between align-items-center">
                                Messages
                                <a href="#" class="small">Mark all as read</a>
                            </div>
                        </li>
                        <li>
                            <div class="message-notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-img">
                                            <img
                                                src="asset/img/jm_denis.jpg"
                                                alt="Img Profile" />
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject">Jimmy Denis</span>
                                            <span class="block"> How are you ? </span>
                                            <span class="time">5 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-img">
                                            <img
                                                src="asset/img/chadengle.jpg"
                                                alt="Img Profile" />
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject">Chad</span>
                                            <span class="block"> Ok, Thanks ! </span>
                                            <span class="time">12 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-img">
                                            <img
                                                src="asset/img/mlane.jpg"
                                                alt="Img Profile" />
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject">Jhon Doe</span>
                                            <span class="block">
                                                Ready for the meeting today...
                                            </span>
                                            <span class="time">12 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-img">
                                            <img
                                                src="asset/img/talha.jpg"
                                                alt="Img Profile" />
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject">Talha</span>
                                            <span class="block"> Hi, Apa Kabar ? </span>
                                            <span class="time">17 minutes ago</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="notifDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="notification">4</span>
                    </a>
                    <ul
                        class="dropdown-menu notif-box animated fadeIn"
                        aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                You have 4 new notification
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-icon notif-primary">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block"> New user registered </span>
                                            <span class="time">5 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-icon notif-success">
                                            <i class="fa fa-comment"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">
                                                Rahmad commented on Admin
                                            </span>
                                            <span class="time">12 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-img">
                                            <img
                                                src="asset/img/profile2.jpg"
                                                alt="Img Profile" />
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">
                                                Reza send messages to you
                                            </span>
                                            <span class="time">12 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-icon notif-danger">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block"> Farrah liked Admin </span>
                                            <span class="time">17 minutes ago</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a
                        class="nav-link"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Quick Actions</span>
                            <span class="subtitle op-7">Shortcuts</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-danger rounded-circle">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            <span class="text">Calendar</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-warning rounded-circle">
                                                <i class="fas fa-map"></i>
                                            </div>
                                            <span class="text">Maps</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-info rounded-circle">
                                                <i class="fas fa-file-excel"></i>
                                            </div>
                                            <span class="text">Reports</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-success rounded-circle">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <span class="text">Emails</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-primary rounded-circle">
                                                <i class="fas fa-file-invoice-dollar"></i>
                                            </div>
                                            <span class="text">Invoice</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-secondary rounded-circle">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <span class="text">Payments</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a
                        class="dropdown-toggle profile-pic"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-expanded="false">
                        @if ($profile)
                        <div class="avatar-sm mx-2">
                            <img src="{{ $profile ? asset('profile/' . $profile->profile) : 'https://via.placeholder.com/100/CCCCCC/FFFFFF' }}" alt="Image Preview" style="display: block; width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd; padding: 5px; cursor: pointer;">
                        </div>
                        <span class="profile-username pt-2">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{$profile->name ?? null}}</span>
                        </span>
                        @else
                        <span class="badge badge-warning ">Please Complete your Profile</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        @if($profile)
                                        <img
                                            src="{{ $profile ? asset('profile/' . $profile->profile) : 'https://via.placeholder.com/100/CCCCCC/FFFFFF' }}"
                                            alt="image profile"
                                            class="avatar-img rounded" />
                                        @else
                                        @endif
                                    </div>
                                    <div class="u-text">
                                        <h4>{{$profile->name ?? null}}</h4>
                                        <p class="text-muted">
                                            {{ $profile && $profile->role == 'admin' 
                                                ? 'Admin' 
                                                : ( $profile && $profile->role == 'org_admin' 
                                                    ? 'Organization Admin' 
                                                    : ($profile && $profile->role == 'instructor' 
                                                        ? 'Instructor' 
                                                        : 'Guest')) 
                                            }}
                                        </p>

                                        <button
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#detailDrawer"
                                            type="button"
                                            class="btn btn-xs btn-secondary btn-sm detail-update">
                                            @if ($profile)
                                            Edit Profile
                                            @else
                                            Complete Profile Details
                                            @endif
                                        </button>
                                        <button
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#organizationDrawer"
                                            type="button"
                                            class="btn btn-xs btn-secondary btn-sm detail-update mt-2">
                                            @if ($profile && !$profile->organization_id)
                                            Build Organization
                                            @else
                                            Edit Organization
                                            @endif
                                        </button>

                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">My Balance</a>
                                <a class="dropdown-item" href="#">Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="offcanvas offcanvas-end" tabindex="-1" id="detailDrawer" aria-labelledby="detailDrawerLabel">
        <div class="offcanvas-header">
            <h5 id="detailDrawerLabel">{{ $profile ? 'Edit Profile' : 'Complete Profile' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Profile form -->
            <form id="detailForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <div class="d-flex justify-content-center align-items-center">
                        <label for="profile" class="form-label">Profile Image</label>
                    </div>
                    <input type="file" name="profile" id="profile" class="form-control" accept="image/*" onchange="previewImage(event)" style="display: none;">
                    <div class="mt-2 d-flex justify-content-center align-items-center">
                        <img id="imagePreview" src="{{ $profile ? asset('profile/' . $profile->profile) : 'https://via.placeholder.com/100/CCCCCC/FFFFFF' }}" alt="Image Preview" style="display: block; width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd; padding: 5px; cursor: pointer;" onclick="document.getElementById('profile').click();">
                    </div>
                </div>

                <div class="mb-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $profile ? $profile->name : old('name') }}" required>
                </div>

                <div class="mb-2">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Please select your role</option>
                        <option value="org_admin" {{ ($profile && $profile->role == 'org_admin') || old('role') == 'org_admin' ? 'selected' : '' }}>Organization Admin</option>
                        <option value="instructor" {{ ($profile && $profile->role == 'instructor') || old('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                        <option value="student" {{ ($profile && $profile->role == 'student') || old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    </select>
                </div>

                {{-- <div class="mb-2">
                    <label for="organization_id" class="form-label">Organization ID</label>
                    <input type="text" name="organization_id" id="organization_id" class="form-control" value="{{ $profile ? $profile->organization->orgId : old('organization_id') }}">
        </div> --}}

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="organizationDrawer" aria-labelledby="organizationDrawerLabel">
    <div class="offcanvas-header">
        <h5 id="organizationDrawerLabel">Build your Organization</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Profile form -->
        <form id="organizationForm" enctype="multipart/form-data">
            @csrf

            <div class="mb-2">
                <div class="d-flex justify-content-center align-items-center">
                    <label for="profile" class="form-label">Organization Image</label>
                </div>
                <input type="file" name="orgImage" id="orgImage" class="form-control" accept="image/*" onchange="previewImageOrg(event)" style="display: none;">
                <div class="mt-2 d-flex justify-content-center align-items-center">
                    <img id="imagePreviewOrg" src="{{ $organization ? asset('orgImage/' . $organization->orgImage) : 'https://img.icons8.com/material-rounded/96/cccccc/groups.png' }}" alt="Image Preview" style="display: block; width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd; padding: 5px; cursor: pointer;" onclick="document.getElementById('orgImage').click();">
                </div>
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="orgName" id="orgName" value="{{ $organization ? $organization->orgName : old('orgName') }}" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Address</label>
                <input type="text" name="address" id="address" value="{{ $organization ? $organization->address : old('address') }}" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Contact</label>
                <input type="text" name="contact" id="contact" value="{{ $organization ? $organization->contact : old('contact') }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>


</div>

<style>

</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>



<script>
    $(document).ready(function() {
        $('#detailForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Create a FormData object from the form
            let formData = new FormData(this);

            // Send the form data via AJAX
            $.ajax({
                url: '{{ route("details-store") }}', // Adjust this to your form submission route
                type: 'POST',
                data: formData,
                processData: false, // Prevents jQuery from processing the data
                contentType: false, // Prevents jQuery from setting the content type
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Profile updated successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload(); // Reload the page after success
                        }
                    });
                },
                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                console.error(key + ": " + errors[key]);
                            }
                        }
                        // Show validation error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: err.responseJSON.errors[Object.keys(err.responseJSON.errors)[0]][0],
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Show general error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: err.responseJSON.message || 'An error occurred',
                            confirmButtonText: 'OK'
                        });
                        console.error(err);
                    }
                }
            });
        });

        // create organization 
        $('#organizationForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Create a FormData object from the form
            let formData = new FormData(this);

            // Send the form data via AJAX
            $.ajax({
                url: '{{ route("organizations-add") }}', // Adjust this to your form submission route
                type: 'POST',
                data: formData,
                processData: false, // Prevents jQuery from processing the data
                contentType: false, // Prevents jQuery from setting the content type
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Organization created successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload(); // Reload the page after success
                        }
                    });
                },
                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                console.error(key + ": " + errors[key]);
                            }
                        }
                        // Show validation error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please check the input data.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Show general error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: err.responseJSON.message || 'An error occurred',
                            confirmButtonText: 'OK'
                        });
                        console.error(err);
                    }
                }
            });
        });

    })

    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result; // Set the source of the image preview
                imagePreview.style.display = 'block'; // Make the image visible
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            imagePreview.src = ''; // Clear the preview if no file is selected
            imagePreview.style.display = 'none'; // Hide the image
        }
    }

    function previewImageOrg(event) {
        const imagePreview = document.getElementById('imagePreviewOrg');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result; // Set the source of the image preview
                imagePreview.style.display = 'block'; // Make the image visible
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            imagePreview.src = ''; // Clear the preview if no file is selected
            imagePreview.style.display = 'none'; // Hide the image
        }
    }
</script>