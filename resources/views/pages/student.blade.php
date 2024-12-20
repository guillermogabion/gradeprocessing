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
                                    <label for="" class="card-title">Students</label>
                                </div>
                                <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary add-item" data-bs-toggle="modal" data-bs-target="#addModal">Add Student</button>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <form method="GET" action="{{ route('students', ['classId' => $classId]) }}">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request()->query('search') }}">
                                            <span class="input-group-append">
                                                <button class="btn btn-outline-secondary d-none" type="submit">Search</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            @foreach($table_header as $header)
                                            <th>{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($items as $item)
                                        @forelse ($item->student as $student)
                                        <tr onclick="window.location='{{ route('assessments', ['classId' => $item->classroom_id, 'studentId' => $student->id]) }}'" style="cursor: pointer;">
                                            <td>{{ $student->studentId ?? 'N/A' }}</td>
                                            <td>{{ $student->fullname ?? 'N/A' }}</td>
                                            <td>{{ $student->address ?? 'N/A' }}</td>
                                            <td>{{ $student->birthdate ?? 'N/A' }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="badge 
                            @if ($item->status == 'active') badge-success
                            @else badge-danger
                            @endif"
                                                        type="button"
                                                        id="dropdownMenuButton{{ $item->id }}"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{ $item->status == 'active' ? 'Confirmed' : 'Pending' }}
                                                    </button>
                                                    <div class="dropdown-menu custom-dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                        <form action="{{ route('student_classroom.updateStatus', [ $item->id, $classId ]) }}" method="POST" id="statusForm{{ $item->id }}">
                                                            @csrf
                                                            <input type="hidden" name="status" id="statusInput{{ $item->id }}" value="">
                                                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); setStatus('active', {{ $item->id }});">Confirm</a>
                                                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); setStatus('inactive', {{ $item->id }});">Decline</a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-rounded btn-icon edit-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    data-id="{{ $item->id }}"
                                                    data-studentid="{{ $student->studentId ?? 'N/A' }}"
                                                    data-fullname="{{ $student->fullname ?? 'N/A' }}"
                                                    data-address="{{ $student->address ?? 'N/A' }}"
                                                    data-birthdate="{{ $student->birthdate ?? 'N/A' }}"
                                                    onclick="event.stopPropagation();">
                                                    <i class="fa fa-edit text-primary"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <i class="fa fa-eye text-primary"></i>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="alert alert-info text-center">No Students</td>
                                        </tr>
                                        @endforelse
                                        @empty
                                        <tr>
                                            <td colspan="6" class="alert alert-info text-center">No Items</td>
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
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Add Student</h5>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                    @csrf


                    <div class="form-group d-none">
                        <input type="text" id="classId" value="{{ $classId }}">
                        <label for="addStudentId">ID:</label>
                        <input type="text" id="addId" name="id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addStudentId">Student ID:</label>
                        <input type="text" id="addStudentId" name="studentId" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addName">Full Name:</label>
                        <input type="text" id="addFullName" name="fullname" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 add-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Update Student</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <!-- <div class="form-group d-flex justify-content-center align-items-center">
                        <div style="position: relative;">
                            <img id="editProfilePreview"
                                src="https://via.placeholder.com/150/cccccc/ffffff?text=Select+Profile"
                                alt="Profile Preview"
                                style="display: block; width: 150px; height: 150px; border-radius: 50%; object-fit: cover; cursor: pointer; margin-top: 10px;"
                                onclick="document.getElementById('editProfilePicture').click()" />
                            <input type="file" id="editProfilePicture" name="profilePicture" class="form-control" accept="image/*" onchange="previewEditImage(event)" style="display: none;">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="editStudentId">Student ID:</label>
                        <input type="text" id="editStudentId" name="studentId" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editFullname">Full Name:</label>
                        <input type="text" id="editFullname" name="fullname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editFullname">Address:</label>
                        <input type="text" id="editAddress" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editFullname">Birthdate:</label>
                        <input type="text" id="editBirthdate" name="birthdate" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 edit-submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let allStudents = @json($all);


        let studentData = allStudents.map(student => ({
            label: `${student.studentId} - ${student.fullname}`,
            value: student.studentId,
            name: student.fullname,
            id: student.id

        }));

        // Initialize autocomplete
        $("#addStudentId").autocomplete({
            source: studentData,
            minLength: 1,
            select: function(event, ui) {
                $("#addStudentId").val(ui.item.value);
                $("#addFullName").val(ui.item.name);
                $("#addId").val(ui.item.id);
                return false;
            }
        });
    });


    $(document).ready(function() {



        $('.edit-btn').click(function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let fullname = $(this).data('fullname');
            let address = $(this).data('address');
            let birthdate = $(this).data('birthdate');
            let studentId = $(this).data('studentid');
            let userProfile = $(this).data('profile');

            $('#editFullname').val(fullname);
            $('#editAddress').val(address);
            $('#editBirthdate').val(birthdate);
            $('#editStudentId').val(studentId);
            $('#editId').val(id);


            if (userProfile) {
                $('#editProfilePreview').attr('src', '/student/' + userProfile); // Use the correct path
            } else {
                $('#editProfilePreview').attr('src', 'https://via.placeholder.com/150/cccccc/ffffff?text=User+Icon');
            }


            $('#editModal').attr('aria-hidden', 'false');
            $('body > *:not(#editModal)').attr('aria-hidden', 'true');
            $('#editModal').modal('show');
        });

        $('.add-btn').click(function(e) {
            e.preventDefault();

            let classId = document.getElementById('classId').value;
            let studentId = document.getElementById('addId').value;

            $.post('/student_adds', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    classroom_id: classId,
                    student_id: studentId,
                })
                .done(function(res) {
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
                })
                .fail(function(err) {
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
                });
        });

        $('.edit-submit-btn').click(function(e) {
            e.preventDefault();

            // Get form values
            let id = $('#editId').val();
            let studentId = $('#editStudentId').val();
            let fullname = $('#editFullname').val();
            let address = $('#editAddress').val();
            let birthdate = $('#editBirthdate').val();
            let profileInput = document.getElementById('editProfilePicture');
            let profilePicture = profileInput && profileInput.files.length > 0 ? profileInput.files[0] : null;

            // Create a FormData object
            let formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            formData.append('id', id);
            formData.append('studentId', studentId);
            formData.append('fullname', fullname);
            formData.append('address', address);
            formData.append('birthdate', birthdate);
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
                url: '/student_update',
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


    });


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

    function setStatus(eventStatus, itemId) {
        document.getElementById('statusInput' + itemId).value = eventStatus;
        document.getElementById('statusForm' + itemId).submit();
    }
</script>
@endsection