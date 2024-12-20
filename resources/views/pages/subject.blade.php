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
                                    <label for="" class="card-title">Subjects</label>
                                </div>
                                @if(auth()->user()->role === 'admin')
                                <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary add-item" data-bs-toggle="modal" data-bs-target="#addModal">Add Subject</button>
                                </div>
                                @endif
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <form method="GET" action="{{ route('organizations-subject') }}">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search subject..." value="{{ request()->query('search') }}">
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
                                                @foreach($table_header as $header)
                                                <th>{{ $header }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name}}</td>
                                                <td>{{ $item->ww }}</td>
                                                <td>{{ $item->pt }}</td>
                                                <td>{{ $item->qa }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-rounded btn-icon edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $item->id }}" data-name="{{$item->name}}" data-ww="{{ $item->ww }}" data-pt="{{ $item->pt }}" data-qa="{{ $item->qa }}">
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
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Add Subject</h5>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group d-none">
                        <label for="addSubjectId">ID:</label>
                        <input type="text" id="addSubjectId" name="id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addName">Subject Name:</label>
                        <input type="text" id="addName" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="addWw">Written Work:</label>
                        <input type="number" id="addWw" name="ww" class="form-control percentage-field" required>
                    </div>
                    <div class="form-group">
                        <label for="addPt">Performance Task:</label>
                        <input type="number" id="addPt" name="pt" class="form-control percentage-field" required>
                    </div>
                    <div class="form-group">
                        <label for="addQa">Quarterly Assessment:</label>
                        <input type="number" id="addQa" name="qa" class="form-control percentage-field" required>
                    </div>

                    <p id="validationMessage" class="text-danger d-none">The total must equal 100.</p>

                    <button type="submit" id="submitButton" class="btn btn-primary mt-4 add-btn" disabled>Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Update Subject</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editName">Name:</label>
                        <input type="text" id="editName" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="editWw">Written Work:</label>
                        <input type="number" id="editWw" name="ww" class="form-control edit-percentage-field" required>
                    </div>
                    <div class="form-group">
                        <label for="editPt">Performance Task:</label>
                        <input type="number" id="editPt" name="pt" class="form-control edit-percentage-field" required>
                    </div>
                    <div class="form-group">
                        <label for="editQa">Quarterly Assessment:</label>
                        <input type="number" id="editQa" name="qa" class="form-control edit-percentage-field" required>
                    </div>

                    <p id="editValidationMessage" class="text-danger d-none">The total must equal 100.</p>

                    <button type="submit" id="editSubmitButton" class="btn btn-primary mt-4 edit-submit-btn" disabled>Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const percentageFields = document.querySelectorAll('.percentage-field');
        const submitButton = document.getElementById('submitButton');
        const validationMessage = document.getElementById('validationMessage');

        function validateTotal() {
            let total = 0;
            percentageFields.forEach(field => {
                total += parseFloat(field.value) || 0;
            });

            if (total === 100) {
                validationMessage.classList.add('d-none');
                submitButton.disabled = false;
            } else {
                validationMessage.classList.remove('d-none');
                validationMessage.textContent = total > 100 ?
                    'The total exceeds 100.' :
                    'The total must equal 100.';
                submitButton.disabled = true;
            }
        }

        percentageFields.forEach(field => {
            field.addEventListener('input', validateTotal);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const editPercentageFields = document.querySelectorAll('.edit-percentage-field');
        const editSubmitButton = document.getElementById('editSubmitButton');
        const editValidationMessage = document.getElementById('editValidationMessage');

        function validateEditTotal() {
            let total = 0;
            editPercentageFields.forEach(field => {
                total += parseFloat(field.value) || 0;
            });

            if (total === 100) {
                editValidationMessage.classList.add('d-none');
                editSubmitButton.disabled = false;
            } else {
                editValidationMessage.classList.remove('d-none');
                editValidationMessage.textContent = total > 100 ?
                    'The total exceeds 100.' :
                    'The total must equal 100.';
                editSubmitButton.disabled = true;
            }
        }

        editPercentageFields.forEach(field => {
            field.addEventListener('input', validateEditTotal);
        });
    });
    $(document).ready(function() {
        let allSubjects = @json($all);

        console.log('test', allSubjects);


        let subjectData = allSubjects.map(subject => ({
            label: `${subject.id} - ${subject.name}`,
            value: subject.id,
            name: subject.name,

        }));

        $("#addName").autocomplete({
            source: subjectData,
            minLength: 1,
            select: function(event, ui) {
                $("#addSubjectId").val(ui.item.value);
                $("#addName").val(ui.item.name);
                return false;
            }
        });
    });

    $('.edit-btn').click(function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let name = $(this).data('name');
        let ww = $(this).data('ww');
        let pt = $(this).data('pt');
        let qa = $(this).data('qa');

        $('#editName').val(name);
        $('#editWw').val(ww);
        $('#editPt').val(pt);
        $('#editQa').val(qa);
        $('#editId').val(id);

        $('#editModal').attr('aria-hidden', 'false');
        $('body > *:not(#editModal)').attr('aria-hidden', 'true');
        $('#editModal').modal('show');
    });
    $(document).ready(function() {
        $('.add-btn').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            let name = document.getElementById('addName').value;
            let ww = document.getElementById('addWw').value;
            let pt = document.getElementById('addPt').value;
            let qa = document.getElementById('addQa').value;

            $.post('subject_add', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    ww: ww,
                    pt: pt,
                    qa: qa,
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
            let name = $('#editName').val();
            let ww = $('#editWw').val();
            let pt = $('#editPt').val();
            let qa = $('#editQa').val();

            $.post('/subject_update', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    name: name,
                    ww: ww,
                    pt: pt,
                    qa: qa,
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
</script>

@endsection