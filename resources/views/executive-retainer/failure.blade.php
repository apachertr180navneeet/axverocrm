@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded text-center py-5">
      <div class="row p-20">
        <div class="col-sm-12">
          <i class="fa fa-times-circle fa-5x text-danger mb-4"></i>
          <h2 class="f-21 font-weight-normal">@lang('app.paymentFailed')</h2>
          <p class="text-muted">@lang('messages.paymentFailedDesc')</p>
          <a href="{{ route('executive-retainer.create') }}" class="btn btn-warning rounded f-14 p-2">
            <i class="fa fa-redo mr-1"></i> @lang('app.tryAgain')
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
