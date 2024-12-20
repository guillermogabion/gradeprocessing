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
                                    <label for="" class="card-title">Class</label>
                                </div>
                                @if(auth()->user()->role !== 'admin')
                                <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary add-item" data-bs-toggle="modal" data-bs-target="#addModal">Add Class</button>
                                </div>
                                @endif
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <form method="GET" action="{{ route('organizations-classrooms') }}">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search class..." value="{{ request()->query('search') }}">
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
                                                @if ($profile && ($profile->role != 'super_admin' && $profile->role != 'admin'))
                                                @foreach($headers_teacher as $header)
                                                <th>{{ $header }}</th>
                                                @endforeach
                                                @else
                                                @foreach($headers as $header)
                                                <th>{{ $header }}</th>
                                                @endforeach
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $item)
                                            <tr onclick="window.location='{{ route('students', ['classId' => $item->id]) }}'" style="cursor: pointer;">
                                                <td>{{ $item->classId }}</td>

                                                @if ($profile && ($profile->role != 'super_admin' && $profile->role != 'admin'))
                                                @else
                                                <td>{{ $item->user->name ?? "NULL" }}</td>
                                                @endif
                                                <td>{{ $item->subject->name ?? NULL }}</td>
                                                <td>{{ $item->class_days }}</td>
                                                <td>{{ $item->class_time }}</td>
                                                <td>{{ $item->duration }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-rounded btn-icon edit-btn {{ $item->status == 'active' ? '' : 'd-none' }}" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $item->id }}" data-name="{{ $item->subject->name }}" data-days="{{ $item->class_days }}" data-time="{{ $item->class_time }}" data-duration="{{ $item->duration }}" onclick="event.stopPropagation();">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </button>
                                                </td>
                                                <td class="">
                                                    <div class="mb-3">
                                                        <form action="{{ route('class.updateStatus', $item->id) }}" method="POST" id="statusForm{{ $item->id }}">
                                                            @csrf
                                                            <label class="form-check-label mb-2" for="activeCheckbox{{ $item->id }}">
                                                                <input type="checkbox" class="form-check-input" id="activeCheckbox{{ $item->id }}" name="active"
                                                                    {{ $item->status == 'active' ? 'checked' : '' }} onclick="event.stopPropagation(); setStatus(this.checked, {{ $item->id }})">
                                                            </label>
                                                        </form>

                                                    </div>
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
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Add Class</h5>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                    @csrf
                    <div class="form-group">
                        <label for="addSubject">Subject:</label>
                        <input type="text" id="addSubjectName" name="subject" class="form-control" required>
                        <input type="text" id="addSubjectId" name="subject" class="form-control d-none" required>
                    </div>
                    <div class="input-group">
                        <select id="addDays" name="days" class="form-control" required>
                            <option value="" disabled selected>Select Days</option>
                            <option value="MonFri">Monday to Friday</option>
                            <option value="MWF">MWF</option>
                            <option value="TTH">TTH</option>
                            <option value="SAT">SAT</option>
                            <option value="SUN">SUN</option>
                        </select>
                        <input placeholder="Select time" type="time" id="addTime" name="time" class="form-control" required>
                        <input placeholder="Duration(Hours)" type="number" id="addDuration" name="duration" class="form-control" required>

                    </div>
                    <button type="submit" class="btn btn-primary mt-4 add-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Update Schedule</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editSubject">Subject:</label>
                        <input type="text" id="editSubject" name="name" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <select id="editDays" name="days" class="form-control" required>
                            <option value="" disabled selected>Select Days</option>
                            <option value="MonFri">Monday to Friday</option>
                            <option value="MWF">MWF</option>
                            <option value="TTH">TTH</option>
                            <option value="SAT">SAT</option>
                            <option value="SUN">SUN</option>
                        </select>
                        <input type="time" id="editTime" name="time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editDuration">Duration:</label>
                        <input type="number" id="editDuration" name="duration" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 edit-submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        let allSubject = @json($all_subject);


        console.log(allSubject, 'yy');

        let subjectData = allSubject.map(subject => ({
            label: `${subject.id} - ${subject.name}`,
            value: subject.id,
            name: subject.name,

        }));

        // Initialize autocomplete
        $("#addSubjectName").autocomplete({
            source: subjectData,
            minLength: 1,
            select: function(event, ui) {
                $("#addSubjectId").val(ui.item.value);
                $("#addSubjectName").val(ui.item.name);
                return false;
            }
        });
    });
    $('.edit-btn').click(function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let name = $(this).data('name');
        let days = $(this).data('days');
        let time = $(this).data('time');
        let duration = $(this).data('duration');
        let addSubjectId = $(this).data('duration');

        $('#editSubject').val(name);
        $('#editDays').val(days);
        $('#editTime').val(time);
        $('#editDuration').val(duration);
        $('#editId').val(id);

        $('#editModal').attr('aria-hidden', 'false');
        $('body > *:not(#editModal)').attr('aria-hidden', 'true');
        $('#editModal').modal('show');
    });
    $(document).ready(function() {
        $('.add-btn').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            let subject_id = document.getElementById('addSubjectId').value;
            let class_days = document.getElementById('addDays').value;
            let class_time = document.getElementById('addTime').value;
            let duration = document.getElementById('addDuration').value;

            $.post('class_add', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    subject_id: subject_id,
                    class_days: class_days,
                    class_time: class_time,
                    duration: duration,
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

        $('.edit-submit-btn').click(function(event) {
            event.preventDefault();

            let id = $('#editId').val();
            let class_days = $('#editDays').val();
            let class_time = $('#editTime').val();
            let duration = $('#editDuration').val();

            $.post('/class_update', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    class_days: class_days,
                    class_time: class_time,
                    duration: duration,
                })
                .done(function(res) {
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
                })
                .fail(function(err) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.responseJSON.message || "An error occurred",
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    console.error(err);
                });
        });
    });

    function setStatus(eventStatus, itemId) {
        // Set the status value in the form before submitting
        const statusInput = document.createElement("input");
        statusInput.type = "hidden";
        statusInput.name = "status"; // or the name you want to send in the form
        statusInput.value = eventStatus ? 'active' : 'inactive';

        // Append the hidden input to the form and submit
        const form = document.getElementById('statusForm' + itemId);
        form.appendChild(statusInput);
        form.submit();
    }

    function toggleStatus(isChecked, itemId) {
        // Submit the form
        document.getElementById('statusForm' + itemId).submit();

        // Change the label text dynamically based on the checkbox state
        let label = document.getElementById('statusLabel' + itemId);
        if (isChecked) {
            label.innerHTML = 'Active'; // Set to Active if checked
        } else {
            label.innerHTML = 'Inactive'; // Set to Inactive if unchecked
        }
    }
</script>

@endsection