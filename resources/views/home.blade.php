@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('admin.dashboard') }}
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @can('reports')
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <h5>{{ trans('admin.statistic_of_revenue_by_month') }}</h5>
                                @if(count($revenue) > 0 && count($months) > 0)

                                    <canvas id="revenueChart"></canvas>
                                @else
                                    {{ trans('admin.no_statistic_of_revenue_yet') }}
                                @endif
                            </div>
                            <div class="col-md-6 text-center">
                                <h5>{{ trans('admin.unpaid_invoices') }}</h5>
                                @if($unpaidInvoices->count() > 0)
                                    <div class="table-responsive">
                                        <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                                            <thead>
                                            <tr>
                                                <th>{{ trans('admin.member_name') }}</th>
                                                <th>{{ trans('admin.invoice_period') }}</th>
                                                <th>{{ trans('admin.amount') }}</th>
                                                <th>{{ trans('admin.resend') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($unpaidInvoices as $invoice)
                                                <tr data-entry-id="{{ $invoice->id }}">
                                                    <td>
                                                        {{ $invoice->student->full_name }}
                                                    </td>
                                                    <td>
                                                        {{ $invoice->period_from }} - {{ $invoice->period_to }}
                                                    </td>
                                                    <td>
                                                        {{ $invoice->total_amount }}
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('admin.invoices.resend', $invoice->id) }}" method="POST" style="display: inline-block;">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-info" value="{{ trans('admin.resend') }}" >
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    {{ trans('admin.there_are_no_unpaid_invoices') }}
                                @endif
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Revenue of month',
                backgroundColor: 'rgb(10, 138, 44)',
                borderColor: 'rgb(10, 138, 44)',
                data:  @json($revenue)
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0,
                    }
                }]
            }}
    });
</script>
@endsection
