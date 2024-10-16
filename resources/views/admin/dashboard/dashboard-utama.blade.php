{{-- @extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Dashboard') }}</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    @foreach ($counts as $model => $count)
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('admin.Total News') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ ucfirst($model) }}</h5>
                                            <p class="card-text">Jumlah: {{ $count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </section>
@endsection --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .section-header {
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .card-icon {
            padding: 20px;
            font-size: 2rem;
            color: white;
            background-color: #4e73df;
        }
        .card-wrap {
            margin-top: 10px;
        }
        .card-header h4 {
            font-size: 1.25rem;
        }
        .card-body {
            padding: 20px;
        }
        .card-body h5 {
            font-size: 1.1rem;
        }
        .card-body p {
            margin-top: 10px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <!-- Loop Start -->
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total News</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Example Model</h5>
                                        <p class="card-text">Jumlah: 123</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Loop End -->
                </div>
            </div>
        </div>
    </section>
</body>
</html>
