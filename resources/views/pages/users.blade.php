@extends('layouts.app')

@section('content')

<div class="page-inner">
    <div class="content-wrapper">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <label for="" class="card-title">Users</label>
                                </div>
                                <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary add-item" data-bs-toggle="modal" data-bs-target="#addModal">Add User</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <form method="GET" action="{{ route('organizations-users') }}">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request()->query('search') }}">
                                            <span class="input-group-append">
                                                <button class="btn btn-outline-secondary d-none" type="submit">Search</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                @foreach($headers as $header)
                                                <th>{{ $header }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->profile)
                                                    <img src="{{ asset('profile/' . $item->profile) }}" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                                    @else
                                                    <img src="https://via.placeholder.com/50" alt="Default Placeholder" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                                    @endif
                                                </td>
                                                <td>{{ $item->userId }}</td>
                                                <td>{{ $item->name ?? "NULL"}}</td>
                                                <td>{{ ucfirst($item->role) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="badge 
                                                                    @if ($item->status == 'active') badge-success
                                                                    @else badge-danger
                                                                    @endif
                                                                    " type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{ $item->status == 'active' ? 'Confirmed' : 'Pending' }}
                                                        </button>
                                                        <div class="dropdown-menu custom-dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                            <form action="{{ route('users.updateStatus', $item->id) }}" method="POST" id="statusForm{{ $item->id }}">
                                                                @csrf
                                                                <input type="hidden" name="status" id="statusInput{{ $item->id }}" value="">
                                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); setStatus('active', {{ $item->id }});">Confirm</a>
                                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); setStatus('disabled', {{ $item->id }});">Decline</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-rounded btn-icon edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $item->id }}" data-userid="{{ $item->userId }}" data-name="{{$item->name}}" data-role="{{ $item->role }}" data-profile="{{ $item->profile }}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="alert alert-info text-center">No Items</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{ $items->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Add User</h5>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                    @csrf

                    <div class="form-group d-flex justify-content-center align-items-center">
                        <div style="position: relative;">
                            <img id="profilePreview"
                                src="https://via.placeholder.com/150/cccccc/ffffff?text=Select+Profile"
                                alt="Profile Preview"
                                style="display: block; max-width: 100%; height: auto; border-radius: 50%; cursor: pointer; margin-top: 10px;"
                                onclick="document.getElementById('addProfilePicture').click()" />
                            <input type="file" id="addProfilePicture" name="profilePicture" class="form-control" accept="image/*" onchange="previewImage(event)" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addUserId">User ID:</label>
                        <input type="text" id="addUserId" name="userId" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addName">Full Name:</label>
                        <input type="text" id="addName" name="userName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addRole">Select a Role:</label>
                        <select class="form-control" id="addRole" name="role" required>
                            <option value="" disabled selected>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 add-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Update User</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group d-flex justify-content-center align-items-center">
                        <div style="position: relative;">
                            <img id="editProfilePreview"
                                src="https://via.placeholder.com/150/cccccc/ffffff?text=Select+Profile"
                                alt="Profile Preview"
                                style="display: block; width: 150px; height: 150px; border-radius: 50%; object-fit: cover; cursor: pointer; margin-top: 10px;"
                                onclick="document.getElementById('editProfilePicture').click()" />
                            <input type="file" id="editProfilePicture" name="profilePicture" class="form-control" accept="image/*" onchange="previewEditImage(event)" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="userUserId">User ID:</label>
                        <input type="text" id="editUserUserId" name="userId" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="userName">Full Name:</label>
                        <input type="text" id="editName" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="userRole">Select a Role:</label>
                        <select class="form-control" id="editRole" name="role" required>
                            <option value="" disabled>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 edit-submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script>
    $(document).ready(function() {



        $('.edit-btn').click(function(e) {
            e.preventDefault();

            // Preload user data when the edit modal is shown
            let id = $(this).data('id');
            let name = $(this).data('name');
            let role = $(this).data('role');
            let userId = $(this).data('userid');
            let userProfile = $(this).data('profile');

            $('#editName').val(name);
            $('#editRole').val(role);
            $('#editUserUserId').val(userId);
            $('#editId').val(id);


            if (userProfile) {
                $('#editProfilePreview').attr('src', '/profile/' + userProfile); // Use the correct path
            } else {
                $('#editProfilePreview').attr('src', 'https://via.placeholder.com/150/cccccc/ffffff?text=User+Icon');
            }


            $('#editModal').attr('aria-hidden', 'false');
            $('body > *:not(#editModal)').attr('aria-hidden', 'true');
            $('#editModal').modal('show');
        });

        $('.add-btn').click(function(e) {
            e.preventDefault();

            // Get form values
            let userId = document.getElementById('addUserId').value;
            let userName = document.getElementById('addName').value;
            let userRole = document.getElementById('addRole').value;
            let profilePicture = document.getElementById('addProfilePicture').files[0]; // Get the file


            // Create a FormData object
            let formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('userId', userId);
            formData.append('name', userName);
            formData.append('role', userRole);
            if (profilePicture) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                if (!validTypes.includes(profilePicture.type)) {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid File Type",
                        text: "Please select a valid image file (jpeg, png, jpg, gif, svg).",
                        confirmButtonText: 'OK'
                    });
                    return; // Stop the submission if invalid type
                }
                formData.append('profilePicture', profilePicture);
            }

            console.log(formData)

            $.ajax({
                url: '/user_add', // Update to your route
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Saving Success',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
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
                        Swal.fire({
                            icon: "error",
                            title: "Validation Error",
                            text: "Please check the input data.",
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: err.responseJSON.message || "An error occurred",
                            confirmButtonText: 'OK'
                        });
                        console.error(err);
                    }
                }
            });
        });
    })


    $('.edit-submit-btn').click(function(e) {
        e.preventDefault();

        // Get form values
        let id = $('#editId').val();
        let editUserId = $('#editUserUserId').val();
        let userName = $('#editName').val();
        let userRole = $('#editRole').val();
        let profileInput = document.getElementById('editProfilePicture');
        let profilePicture = profileInput && profileInput.files.length > 0 ? profileInput.files[0] : null;

        // Create a FormData object
        let formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        formData.append('id', id);
        formData.append('userId', editUserId);
        formData.append('name', userName);
        formData.append('role', userRole);
        if (profilePicture) {
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
            if (!validTypes.includes(profilePicture.type)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid File Type",
                    text: "Please select a valid image file (jpeg, png, jpg, gif, svg).",
                    confirmButtonText: 'OK'
                });
                return; // Stop the submission if invalid type
            }
            formData.append('profilePicture', profilePicture);
        }

        console.log(formData);

        $.ajax({
            url: '/user_update',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Update Success',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
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
                    Swal.fire({
                        icon: "error",
                        title: "Validation Error",
                        text: "Please check the input data.",
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.responseJSON.message || "An error occurred",
                        confirmButtonText: 'OK'
                    });
                    console.error(err);
                }
            }
        });
    });



    function setStatus(eventStatus, itemId) {
        document.getElementById('statusInput' + itemId).value = eventStatus;
        document.getElementById('statusForm' + itemId).submit();
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const profilePreview = document.getElementById('profilePreview');
            profilePreview.src = e.target.result;
            profilePreview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            document.getElementById('profilePreview').src = 'https://via.placeholder.com/150/cccccc/ffffff?text=User+Icon';
        }
    }

    function previewEditImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('editProfilePreview');
            output.src = reader.result; // Update the image preview in Edit modal
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection