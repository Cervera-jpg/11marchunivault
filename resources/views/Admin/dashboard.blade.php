@extends('layouts.user_type.auth')

@section('content')
<div>
    <!-- Summary Cards Row -->
    <div class="row">
        <!-- Total Items Card -->
        <div class="col-xl-4 col-sm-6 mb-xl-2 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Items</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalItems }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape shadow text-center border-radius-md">
                                <i class="ni ni-box-2 text-white text-lg opacity-10" style="background-color: #821131; padding: 8px; border-radius: 5px;" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert Card -->
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Low Stock Items</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $lowStockCount }}
                                    @if($lowStockCount > 0)
                                        <span class="text-danger text-sm font-weight-bolder">Needs to Restock</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape shadow text-center border-radius-md">
                                <i class="ni ni-notification-70 text-white text-lg opacity-10" style="background-color: #821131; padding: 8px; border-radius: 5px;" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Value Card -->
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Value</p>
                                <h5 class="font-weight-bolder mb-0">
                                    ₱{{ number_format($totalValue, 2) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape shadow text-center border-radius-md">
                                <i class="ni ni-money-coins text-white text-lg opacity-10" style="background-color: #821131; padding: 8px; border-radius: 5px;" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="row mt-4">
        <!-- User Statistics -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>User Statistics</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metric</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Count</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3">
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">{{ $userStats['metric'] }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $userStats['count'] }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">
                                            {{ $userStats['last_joined'] ? Carbon\Carbon::parse($userStats['last_joined'])->format('M d, Y') : '-' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Stock Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Stock Overview</h6>
                    <div class="btn-group" style="margin-bottom: 10px;">
                        <form id="periodForm" class="mb-0">
                            <select class="form-select form-select-sm custom-select" name="period" id="period-selector">
                                <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="annually" {{ $period === 'annually' ? 'selected' : '' }}>Annually</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="stocks-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Stock Movements -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Recent Stock Movements</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Department</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStocks as $stock)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3">
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">{{ $stock->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $stock->department }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $stock->category }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $stock->quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">₱{{ number_format($stock->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">₱{{ number_format($stock->price * $stock->quantity, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $stock->created_at->format('M d, Y') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('dashboard-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("stocks-chart").getContext("2d");
        var chart;
        
        function initChart() {
            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: {!! json_encode($stockData->pluck('label')) !!},
                    datasets: [{
                        label: "Stocks",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "#821131",
                        data: {!! json_encode($stockData->pluck('count')) !!},
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Stock Overview - ' + document.getElementById('period-selector').value.charAt(0).toUpperCase() + document.getElementById('period-selector').value.slice(1)
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#9ca2b7"
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false
                            },
                            ticks: {
                                display: true,
                                color: "#9ca2b7",
                                padding: 10
                            }
                        },
                    },
                },
            });
        }

        // Initialize chart
        initChart();

        // Handle period change
        document.getElementById('period-selector').addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush

<style>
.custom-select {
    padding: 4px 24px 4px 12px;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #821131;  /* Light red text color */
    background-color: #D22B2B;
    border: 1px solid #821131;  /* Light red border */
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
    cursor: pointer;
}

.custom-select:hover {
    background-color: #F88379;  /* Very light red background on hover */
}

.custom-select:focus {
    border-color: #821131;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>
