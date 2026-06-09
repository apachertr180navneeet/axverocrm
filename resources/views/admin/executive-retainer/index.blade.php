@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <x-app-title class="d-block d-lg-none" :pageTitle="$pageTitle"></x-app-title>
      <h4 class="f-21 f-w-500 mb-0 d-none d-lg-block">{{ $pageTitle }}</h4>
      <div class="d-flex">
        <a href="{{ route('admin.executive-retainer.create') }}" class="btn btn-primary rounded f-14 p-2">
          <i class="fa fa-plus mr-1"></i> @lang('app.add') Application
        </a>
      </div>
    </div>

    <form method="GET" id="filter-form">
      <div class="d-lg-flex d-md-flex d-block flex-wrap filter-box bg-white rounded mb-3 p-3">
        <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey border-right-grey-sm-0">
          <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.search')</p>
          <div class="select-status">
            <input type="text" name="search" class="form-control f-14" placeholder="Name / Mobile / Email"
              value="{{ request('search') }}">
          </div>
        </div>
        <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey border-right-grey-sm-0">
          <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.post')</p>
          <div class="select-status">
            <select name="post" class="form-control select-picker">
              <option value="">@lang('app.all')</option>
              <option value="HR Executive" {{ request('post') == 'HR Executive' ? 'selected' : '' }}>HR Executive</option>
              <option value="Retainer" {{ request('post') == 'Retainer' ? 'selected' : '' }}>Retainer</option>
            </select>
          </div>
        </div>
        <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey border-right-grey-sm-0">
          <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.paymentStatus')</p>
          <div class="select-status">
            <select name="payment_status" class="form-control select-picker">
              <option value="">@lang('app.all')</option>
              <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>@lang('app.pending')</option>
              <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>@lang('app.success')</option>
              <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>@lang('app.failed')</option>
            </select>
          </div>
        </div>
        <div class="d-flex py-1 px-lg-2 px-md-2 px-0 align-items-center">
          <button type="submit" class="btn btn-primary rounded f-14 p-2 mr-2">
            <i class="fa fa-search mr-1"></i> @lang('app.filter')
          </button>
          @if(request()->anyFilled(['search', 'post', 'payment_status']))
            <a href="{{ route('admin.executive-retainer.index') }}" class="btn btn-secondary rounded f-14 p-2">
              <i class="fa fa-times-circle mr-1"></i> @lang('app.clearFilters')
            </a>
          @endif
        </div>
      </div>
    </form>

    <x-cards.data padding="false">
      <x-table class="table-hover">
        <x-slot name="thead">
          <th>#</th>
          <th>@lang('app.name')</th>
          <th>@lang('app.mobile')</th>
          <th>@lang('app.post')</th>
          <th>@lang('app.joiningDate')</th>
          <th>@lang('app.amount')</th>
          <th>@lang('app.paymentStatus')</th>
        </x-slot>
        @forelse($applications as $app)
          <tr>
            <td>{{ $app->id }}</td>
            <td>
              <div class="media-body">
                <h5 class="mb-0 f-12 text-darkest-grey">{{ $app->name }}</h5>
                <p class="mb-0 f-12 text-dark-grey">{{ $app->email }}</p>
              </div>
            </td>
            <td>{{ $app->mobile }}</td>
            <td>{{ $app->post }}</td>
            <td>{{ $app->date_of_joining->format('d-m-Y') }}</td>
            <td>&#x20B9;{{ number_format($app->amount, 2) }}</td>
            <td>
              @if($app->payment_status == 'success')
                <span class="badge badge-success">@lang('app.success')</span>
              @elseif($app->payment_status == 'pending')
                <span class="badge badge-warning">@lang('app.pending')</span>
              @else
                <span class="badge badge-danger">@lang('app.failed')</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">@lang('messages.noRecordFound')</td>
          </tr>
        @endforelse
      </x-table>
    </x-cards.data>

    <div class="mt-3">
      {{ $applications->appends(request()->query())->links() }}
    </div>
  </div>
@endsection
