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

                                    <label for="" class="card-title">Assessment Record ({{$student->fullname ?? NULL}})</label>
                                </div>
                                <div class="col-lg-6 col-md-6 d-flex justify-content-end align-items-right mb-2">
                                    <button type="button" class="btn btn-primary add-item" data-bs-toggle="modal" data-bs-target="#addModal">Add Assessment Details</button>
                                </div>


                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Parameter</th>
                                            <th>1st Quarter</th>
                                            <th>2nd Quarter</th>
                                            <th>3rd Quarter</th>
                                            <th>4th Quarter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Written Work</td>
                                            <td>{{ isset($calculatedScoresByQuarter['ww']['1st']) ? number_format($calculatedScoresByQuarter['ww']['1st'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['ww']['2nd']) ? number_format($calculatedScoresByQuarter['ww']['2nd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['ww']['3rd']) ? number_format($calculatedScoresByQuarter['ww']['3rd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['ww']['4th']) ? number_format($calculatedScoresByQuarter['ww']['4th'] * 100, 2) . '%' : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Performance Task</td>
                                            <td>{{ isset($calculatedScoresByQuarter['pt']['1st']) ? number_format($calculatedScoresByQuarter['pt']['1st'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['pt']['2nd']) ? number_format($calculatedScoresByQuarter['pt']['2nd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['pt']['3rd']) ? number_format($calculatedScoresByQuarter['pt']['3rd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['pt']['4th']) ? number_format($calculatedScoresByQuarter['pt']['4th'] * 100, 2) . '%' : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Quarter Assessment</td>
                                            <td>{{ isset($calculatedScoresByQuarter['qa']['1st']) ? number_format($calculatedScoresByQuarter['qa']['1st'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['qa']['2nd']) ? number_format($calculatedScoresByQuarter['qa']['2nd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['qa']['3rd']) ? number_format($calculatedScoresByQuarter['qa']['3rd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($calculatedScoresByQuarter['qa']['4th']) ? number_format($calculatedScoresByQuarter['qa']['4th'] * 100, 2) . '%' : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Score</td>
                                            <td>{{ isset($totalCalculatedScoreByQuarter['1st']) ? number_format($totalCalculatedScoreByQuarter['1st'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($totalCalculatedScoreByQuarter['2nd']) ? number_format($totalCalculatedScoreByQuarter['2nd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($totalCalculatedScoreByQuarter['3rd']) ? number_format($totalCalculatedScoreByQuarter['3rd'] * 100, 2) . '%' : '' }}</td>
                                            <td>{{ isset($totalCalculatedScoreByQuarter['4th']) ? number_format($totalCalculatedScoreByQuarter['4th'] * 100, 2) . '%' : '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>


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
                                                <td>
                                                    @if ($item->assessment_type == 'ww')
                                                    Written Work
                                                    @elseif ($item->assessment_type == 'pt')
                                                    Performance Task
                                                    @elseif ($item->assessment_type == 'qa')
                                                    Quarterly Assessment
                                                    @else
                                                    {{ $item->assessment_type }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->quarter == '1st')
                                                    First Quarter
                                                    @elseif ($item->quarter == '2nd')
                                                    Second Quarter
                                                    @elseif ($item->quarter == '3rd')
                                                    Third Quarter
                                                    @elseif ($item->quarter == '4th')
                                                    Fourth Quarter
                                                    @else
                                                    {{ $item->assessment_type }}
                                                    @endif
                                                </td>
                                                <td>{{ $item->score }}</td>
                                                <td>{{ $item->max_score }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-rounded btn-icon edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $item->id }}" data-assessment_type="{{$item->assessment_type}}" data-score="{{ $item->score }}" data-maxscore="{{ $item->max_score }}" data-date="{{ $item->date }}" data-quarter="{{ $item->quarter }}">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Add Assessment Details</h5>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="classId" id="classId" value="{{$classId}}">
                    <input type="hidden" name="studentId" id="classId" value="{{$studentId}}">
                    <div id="fieldContainer">
                        <div class="field-group">
                            <div class="form-group">
                                <label for="addAssessmentType">Assessment Type:</label>
                                <select class="form-control" name="assessment_type[]" required>
                                    <option value="" disabled selected>Select an assessment</option>
                                    <option value="ww">Written Work</option>
                                    <option value="pt">Performance Task</option>
                                    <option value="qa">Quarterly Assessment</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="addAssessmentType">Quarter Period:</label>
                                <select class="form-control" name="quarter[]" required>
                                    <option value="" disabled selected>Select Quarter Period</option>
                                    <option value="1st">First Quarter</option>
                                    <option value="2nd">Second Quarter</option>
                                    <option value="3rd">Third Quarter</option>
                                    <option value="4th">Fourth Quarter</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="addScore">Score:</label>
                                        <input type="number" name="score[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="addMaxScore">Total Items:</label>
                                        <input type="number" name="max_score[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="addDate">Date Executed:</label>
                                        <input type="date" name="date_executed[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="addImage">Add Image(Optional):</label>
                                        <input type="text" name="image[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger remove-field">Remove</button>
                            <hr>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success add-field mt-4">Add More</button>
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Update Assessment Detail</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf


                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" name="classId" id="classId" value="{{$classId}}">
                    <input type="hidden" name="studentId" id="classId" value="{{$studentId}}">
                    <div class="form-group">
                        <label for="editName">Assessment Type:</label>
                        <input type="text" id="editType" name="assessment_type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editQuarter">Quarter Period:</label>
                        <select class="form-control" id="editQuarter" name="quarter" required>
                            <option value="" disabled selected>Select Quarter Period</option>
                            <option value="1st">First Quarter</option>
                            <option value="2nd">Second Quarter</option>
                            <option value="3rd">Third Quarter</option>
                            <option value="4th">Fourth Quarter</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editScore">Score:</label>
                        <input type="text" id="editScore" name="score" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editMaxScore">Maximum Score:</label>
                        <input type="text" id="editMaxScore" name="max_score" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="addQa">Date:</label>
                        <input type="date" id="editDate" name="qa" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 edit-submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('.edit-btn').click(function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let assessment_type = $(this).data('assessment_type');
        let score = $(this).data('score');
        let max_score = $(this).data('maxscore');
        let date = $(this).data('date');
        let quarter = $(this).data('quarter');

        $('#editType').val(assessment_type);
        $('#editScore').val(score);
        $('#editMaxScore').val(max_score);
        $('#editDate').val(date);
        $('#editQuarter').val(quarter);
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
            let assessment_type = $('#editType').val();
            let gotScore = $('#editScore').val();
            let max_score = $('#editMaxScore').val();
            let date = $('#editDate').val();
            let quarter = $('#editQuarter').val();
            let score = (gotScore / max_score) * 100;

            $.post('/assessment_update', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    assessment_type: assessment_type,
                    score: score,
                    max_score: max_score,
                    date: date,
                    quarter: quarter,
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

        $('#addForm').on('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            const form = $(this);

            // Log the form data for debugging
            console.log(form.serialize(), 'test');

            // Loop through the input fields to calculate percentage
            let totalItems = $('input[name="max_score[]"]');
            let scores = $('input[name="score[]"]');
            let percentages = [];

            totalItems.each(function(index) {
                let maxScore = $(this).val();
                let score = $(scores[index]).val();

                if (maxScore && score) {
                    let percentage = (score / maxScore) * 100; // Calculate percentage based on max_score
                    percentages.push(percentage);
                }
            });

            // Log the calculated percentages for debugging
            console.log(percentages);

            $.ajax({
                url: '/assessment_add', // Replace with your endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form.serialize(), // Serialize form data
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Assessment details have been added successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    // Close the modal after submission
                    $('#addModal').modal('hide');
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Add more fields dynamically
        function updateRemoveButtonVisibility() {
            const fieldGroupsCount = $('#fieldContainer .field-group').length;
            $('#fieldContainer .field-group').each(function() {
                const removeButton = $(this).find('.remove-field');
                if (fieldGroupsCount <= 1) {
                    removeButton.hide(); // Hide the remove button if only one field group remains
                } else {
                    removeButton.show(); // Show the remove button if more than one field group remains
                }
            });
        }

        // Trigger initial visibility check
        updateRemoveButtonVisibility();

        // Add more fields dynamically
        $('.add-field').on('click', function() {
            const newFieldGroup = $('#fieldContainer .field-group:first').clone();
            newFieldGroup.find('input').val(''); // Reset input fields
            $('#fieldContainer').append(newFieldGroup);

            // Update remove button visibility after adding a new field group
            updateRemoveButtonVisibility();
        });

        // Remove a field group
        $('#fieldContainer').on('click', '.remove-field', function() {
            $(this).closest('.field-group').remove();

            // Update remove button visibility after removing a field group
            updateRemoveButtonVisibility();
        });
    });
</script>

@endsection