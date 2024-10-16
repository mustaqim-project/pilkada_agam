@extends('admin.layouts.master')

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
@endsection
