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
                                    <label for="" class="card-title">Ratings</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <form method="GET" action="{{ route('organizations-rating') }}">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search Student or Class ID" value="{{ request()->query('search') }}">
                                            <span class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Only show table if search term exists -->
                            @if(request()->has('search') && request()->query('search') != '')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Class ID</th>
                                                <th>Subject</th>
                                                <th>First Quarter</th>
                                                <th>Second Quarter</th>
                                                <th>Third Quarter</th>
                                                <th>Fourth Quarter</th>
                                                <th>Average</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $row)
                                            <tr>
                                                <td>{{ $row->fullname }}</td>
                                                <td>{{ $row->class_id }}</td>
                                                <td>{{ $row->subject }}</td>
                                                <td>{{ number_format($row->first_quarter * 100, 2) }}%</td>
                                                <td>{{ number_format($row->second_quarter * 100, 2) }}%</td>
                                                <td>{{ number_format($row->third_quarter * 100, 2) }}%</td>
                                                <td>{{ number_format($row->fourth_quarter * 100, 2) }}%</td>
                                                <td>{{ number_format(
                                                        (($row->first_quarter + $row->second_quarter + $row->third_quarter + $row->fourth_quarter) / 4) * 100, 2)
                                                    }}%
                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No records found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end">
                                    {{ $data->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                            @else
                            <p class="text-center mt-4">Please enter a search term to view data.</p> <!-- Show message if no search term -->
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection