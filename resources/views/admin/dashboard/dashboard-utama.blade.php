@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Dashboard') }}</h1>
        </div>
        <div class="row">
            @foreach ($counts as $model => $count)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-chart"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ ucfirst($model) }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
