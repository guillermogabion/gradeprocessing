@php
use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div
        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div
                                class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Users</p>
                                <h4 class="card-title">{{$users}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div
                                class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Students</p>
                                <h4 class="card-title">{{$students}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div
                                class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-door-open"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Active Class</p>
                                <h4 class="card-title">{{$class}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div
                                class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Subject</p>
                                <h4 class="card-title">{{$subject}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Students Statistics</div>
                        <div class="card-tools">
                            <a
                                href="#"
                                class="btn btn-label-success btn-round btn-sm me-2">
                                <span class="btn-label">
                                    <i class="fa fa-pencil"></i>
                                </span>
                                Export
                            </a>
                            <a href="#" class="btn btn-label-info btn-round btn-sm">
                                <span class="btn-label">
                                    <i class="fa fa-print"></i>
                                </span>
                                Print
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                        <canvas id="assessmentChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="container">
                            <h1>Class Schedule for {{ $startOfMonth->format('F Y') }}</h1>

                            <!-- Navigation to switch months -->
                            <div class="d-flex justify-content-between mb-3">
                                <a href="{{ route('home', ['month' => $startOfMonth->subMonth()->month, 'year' => $startOfMonth->year]) }}" class="btn btn-primary">Previous Month</a>
                                <a href="{{ route('home', ['month' => $startOfMonth->addMonth()->month, 'year' => $startOfMonth->year]) }}" class="btn btn-primary">Next Month</a>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sunday</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $daysInMonth = $startOfMonth->daysInMonth;
                                    $firstDayOfWeek = $startOfMonth->copy()->startOfMonth()->dayOfWeek;
                                    @endphp
                                    @for ($i = 0; $i < $daysInMonth + $firstDayOfWeek; $i++)
                                        @if ($i % 7==0)
                                        <tr>
                                        @endif
                                        <td>
                                            @if ($i >= $firstDayOfWeek)
                                            @php
                                            $currentDay = $i - $firstDayOfWeek + 1;
                                            @endphp
                                            <div class="day-number">{{ $currentDay }}</div>
                                            @foreach ($classData as $class)
                                            @if (in_array(Carbon::createFromDate($year, $month, $currentDay)->format('l'), $class['classDays']))
                                            <div class="class-schedule">
                                                <strong>{{ $class['subject'] }}</strong><br>
                                                {{ $class['classTime'] }} ({{ $class['duration'] }})
                                            </div>
                                            @endif
                                            @endforeach
                                            @endif
                                        </td>
                                        @if (($i + 1) % 7 == 0)
                                        </tr>
                                        @endif
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            <div class="card card-round">
                <div class="card-body pb-0">
                    <div class="h1 fw-bold float-end text-primary">+5%</div>
                    <h2 class="mb-2">17</h2>
                    <p class="text-muted">Users online</p>
                    <div class="pull-in sparkline-fix">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <h4 class="card-title">Users Geolocation</h4>
                        <div class="card-tools">
                            <button
                                class="btn btn-icon btn-link btn-primary btn-xs">
                                <span class="fa fa-angle-down"></span>
                            </button>
                            <button
                                class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
                                <span class="fa fa-sync-alt"></span>
                            </button>
                            <button
                                class="btn btn-icon btn-link btn-primary btn-xs">
                                <span class="fa fa-times"></span>
                            </button>
                        </div>
                    </div>
                    <p class="card-category">
                        Map of the distribution of users around the world
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive table-hover table-sales">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="flag">
                                                    <img
                                                        src="{{asset('img/flags/id.png')}}"
                                                        alt="indonesia" />
                                                </div>
                                            </td>
                                            <td>Indonesia</td>
                                            <td class="text-end">2.320</td>
                                            <td class="text-end">42.18%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flag">
                                                    <img
                                                        src="{{asset('img/flags/us.png')}}"
                                                        alt="united states" />
                                                </div>
                                            </td>
                                            <td>USA</td>
                                            <td class="text-end">240</td>
                                            <td class="text-end">4.36%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flag">
                                                    <img
                                                        src="{{asset('img/flags/au.png')}}"
                                                        alt="australia" />
                                                </div>
                                            </td>
                                            <td>Australia</td>
                                            <td class="text-end">119</td>
                                            <td class="text-end">2.16%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flag">
                                                    <img
                                                        src="{{asset('img/flags/ru.png')}}"
                                                        alt="russia" />
                                                </div>
                                            </td>
                                            <td>Russia</td>
                                            <td class="text-end">1.081</td>
                                            <td class="text-end">19.65%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flag">
                                                    <img
                                                        src="{{asset('img/flags/cn.png')}}"
                                                        alt="china" />
                                                </div>
                                            </td>
                                            <td>China</td>
                                            <td class="text-end">1.100</td>
                                            <td class="text-end">20%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flag">
                                                    <img
                                                        src="{{asset('img/flags/br.png')}}"
                                                        alt="brazil" />
                                                </div>
                                            </td>
                                            <td>Brasil</td>
                                            <td class="text-end">640</td>
                                            <td class="text-end">11.63%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mapcontainer">
                                <div
                                    id="world-map"
                                    class="w-100"
                                    style="height: 300px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">New Customers</div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button
                                    class="btn btn-icon btn-clean me-0"
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-list py-4">
                        <div class="item-list">
                            <div class="avatar">
                                <img
                                    src="{{asset('img/jm_denis.jpg')}}"
                                    alt="..."
                                    class="avatar-img rounded-circle" />
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">Jimmy Denis</div>
                                <div class="status">Graphic Designer</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
                            <button class="btn btn-icon btn-link btn-danger op-8">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                        <div class="item-list">
                            <div class="avatar">
                                <span
                                    class="avatar-title rounded-circle border border-white">CF</span>
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">Chandra Felix</div>
                                <div class="status">Sales Promotion</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
                            <button class="btn btn-icon btn-link btn-danger op-8">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                        <div class="item-list">
                            <div class="avatar">
                                <img
                                    src="{{asset('img/talha.jpg')}}"
                                    alt="..."
                                    class="avatar-img rounded-circle" />
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">Talha</div>
                                <div class="status">Front End Designer</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
                            <button class="btn btn-icon btn-link btn-danger op-8">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                        <div class="item-list">
                            <div class="avatar">
                                <img
                                    src="{{asset('img/chadengle.jpg')}}"
                                    alt="..."
                                    class="avatar-img rounded-circle" />
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">Chad</div>
                                <div class="status">CEO Zeleaf</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
                            <button class="btn btn-icon btn-link btn-danger op-8">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                        <div class="item-list">
                            <div class="avatar">
                                <span
                                    class="avatar-title rounded-circle border border-white bg-primary">H</span>
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">Hizrian</div>
                                <div class="status">Web Designer</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
                            <button class="btn btn-icon btn-link btn-danger op-8">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                        <div class="item-list">
                            <div class="avatar">
                                <span
                                    class="avatar-title rounded-circle border border-white bg-secondary">F</span>
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">Farrah</div>
                                <div class="status">Marketing</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
                            <button class="btn btn-icon btn-link btn-danger op-8">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Transaction History</div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button
                                    class="btn btn-icon btn-clean me-0"
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Payment Number</th>
                                    <th scope="col" class="text-end">Date & Time</th>
                                    <th scope="col" class="text-end">Amount</th>
                                    <th scope="col" class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <button
                                            class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        Payment from #10231
                                    </th>
                                    <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                    <td class="text-end">$250.00</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for the chart
    var data = @json($studentsByYear); // Pass the grouped data from Laravel
    var years = data.map(item => item.year); // Extract the years
    var totalStudents = data.map(item => item.total_students); // Extract total student counts

    // Set up the chart
    var ctx = document.getElementById('assessmentChart').getContext('2d');
    var assessmentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years, // Use years as labels
            datasets: [{
                label: 'Total Students',
                borderColor: '#3AA0F3', // Line color
                backgroundColor: 'rgba(58, 160, 243, 0.4)', // Semi-transparent background color
                data: totalStudents, // Use total students data
                fill: true,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true, // Ensure the Y-axis starts at zero
                    title: {
                        display: true,
                        text: 'Number of Students', // Y-axis label
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Year', // X-axis label
                    },
                    ticks: {
                        autoSkip: false
                    }
                },
            },
            plugins: {
                legend: {
                    display: true, // Show the legend
                    position: 'top',
                }
            }
        }
    });

    $(document).ready(function() {
        // Ajax request to load new month schedule without reloading the page
        $('a.btn-outline-secondary').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // Update the content dynamically without reloading the page
                    $('.card-body').html($(data).find('.card-body').html());
                }
            });
        });
    });
</script>


@endsection