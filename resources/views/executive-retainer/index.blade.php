@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')
    <form method="GET" id="filter-form">
        <x-filters.filter-box>
            <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.post')</p>
                <div class="select-status">
                    <select name="post" class="form-control select-picker" id="post-filter" onchange="this.form.submit()">
                        <option value="">@lang('app.all')</option>
                        <option value="HR Executive" {{ request('post') == 'HR Executive' ? 'selected' : '' }}>HR Executive</option>
                        <option value="Retainer" {{ request('post') == 'Retainer' ? 'selected' : '' }}>@lang('app.retainer')</option>
                    </select>
                </div>
            </div>

            <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.paymentStatus')</p>
                <div class="select-status">
                    <select name="payment_status" class="form-control select-picker" id="payment-status-filter" onchange="this.form.submit()">
                        <option value="">@lang('app.all')</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>@lang('app.pending')</option>
                        <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>@lang('app.success')</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>@lang('app.failed')</option>
                    </select>
                </div>
            </div>

            <div class="task-search d-flex py-1 px-lg-3 px-0 border-right-grey align-items-center">
                <div class="w-100 mr-1 mr-lg-0 mr-md-1 ml-md-1 ml-0 ml-lg-0">
                    <div class="input-group bg-grey rounded">
                        <div class="input-group-prepend">
                            <span class="input-group-text border-0 bg-additional-grey">
                                <i class="fa fa-search f-13 text-dark-grey"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control f-14 p-1 border-additional-grey" id="search-text-field"
                            placeholder="@lang('app.startTyping')" value="{{ request('search') }}">
                    </div>
                </div>
            </div>

            <div class="select-box d-flex py-1 px-lg-2 px-md-2 px-0">
                <x-forms.button-secondary class="btn-xs d-none" id="reset-filters" icon="times-circle">
                    @lang('app.clearFilters')
                </x-forms.button-secondary>
            </div>
        </x-filters.filter-box>
    </form>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <x-app-title class="d-block d-lg-none" :pageTitle="$pageTitle"></x-app-title>
        <h4 class="f-21 f-w-500 mb-0 d-none d-lg-block">{{ $pageTitle }}</h4>
        <div class="d-flex">
            <a href="{{ route('executive-retainer.create') }}" class="btn btn-primary rounded f-14 p-2">
                <i class="fa fa-plus mr-1"></i> @lang('app.add') Application
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <x-cards.widget :title="__('app.total') . ' ' . 'Applications'" value="{{ $stats['total'] }}"
                icon="file-alt" widgetId="total-applications" />
        </div>
        <div class="col-md-3">
            <x-cards.widget :title="__('app.pending') . ' ' . __('app.menu.payments')" value="{{ $stats['pending'] }}"
                icon="clock" widgetId="pending-payments" />
        </div>
        <div class="col-md-3">
            <x-cards.widget :title="'Successful' . ' ' . __('app.menu.payments')" value="{{ $stats['success'] }}"
                icon="check-circle" widgetId="success-payments" />
        </div>
        <div class="col-md-3">
            <x-cards.widget :title="__('app.failed') . ' ' . __('app.menu.payments')" value="{{ $stats['failed'] }}"
                icon="times-circle" widgetId="failed-payments" />
        </div>
    </div>

    <x-cards.data padding="false" otherClasses="pt-0 mx-3 mb-3">
        <x-table class="table-hover">
            <x-slot name="thead">
                <th>#</th>
                <th>@lang('app.name')</th>
                <th>@lang('app.mobile')</th>
                <th>@lang('app.post')</th>
                <th>@lang('app.joiningDate')</th>
                <th>@lang('app.amount')</th>
                <th width="10%">@lang('app.paymentStatus')</th>
                <th width="5%" class="text-right">@lang('app.action')</th>
            </x-slot>
            @forelse($applications as $app)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="media-body">
                            <h5 class="mb-0 f-12 text-darkest-grey">{{ $app->name }}</h5>
                            <p class="mb-0 f-12 text-dark-grey">{{ $app->email }}</p>
                        </div>
                    </td>
                    <td>
                        <a href="tel:{{ $app->mobile }}" class="text-dark-grey f-12">{{ $app->mobile }}</a>
                    </td>
                    <td>
                        @if($app->post == 'HR Executive')
                            <span class="badge badge-primary">{{ $app->post }}</span>
                        @else
                            <span class="badge badge-info">@lang('app.retainer')</span>
                        @endif
                    </td>
                    <td>{{ $app->date_of_joining->format('d-m-Y') }}</td>
                    <td>&#x20B9;{{ number_format($app->amount, 2) }}</td>
                    <td>
                        @if($app->payment_status == 'success')
                            <i class="fa fa-check-circle text-success"></i>
                        @elseif($app->payment_status == 'pending')
                            <i class="fa fa-clock text-warning"></i>
                        @else
                            <i class="fa fa-times-circle text-danger"></i>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('executive-retainer.show', $app->id) }}" class="text-dark-grey">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fa fa-inbox fa-3x mb-3 d-block"></i>
                        @lang('messages.noRecordFound')
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-cards.data>

    <div class="mt-3">
        {{ $applications->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function toggleResetBtn() {
            if ($('#search-text-field').val().length > 0 || $('#post-filter').val() || $('#payment-status-filter').val()) {
                $('#reset-filters').removeClass('d-none');
            } else {
                $('#reset-filters').addClass('d-none');
            }
        }
        $('#search-text-field, #post-filter, #payment-status-filter').on('change keyup', toggleResetBtn);
        toggleResetBtn();

        let searchTimer;
        $('#search-text-field').on('keyup', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => $('#filter-form').submit(), 500);
        });

        $('#reset-filters').click(function () {
            $('#search-text-field').val('');
            $('#post-filter').selectpicker('val', '');
            $('#payment-status-filter').selectpicker('val', '');
            $('#filter-form').submit();
        });
    </script>
@endpush
