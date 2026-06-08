@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded text-center py-5">
      <div class="row p-20">
        <div class="col-sm-12">
          <i class="fa fa-check-circle fa-5x text-success mb-4"></i>
          <h2 class="f-21 font-weight-normal">@lang('app.paymentSuccessful')</h2>
          <p class="text-muted">@lang('messages.applicationSubmitted', ['id' => $application->id])</p>
          <a href="{{ route(in_array('admin', user_roles()) ? 'admin.dashboard' : 'dashboard') }}" class="btn btn-primary rounded f-14 p-2">
            <i class="fa fa-tachometer mr-1"></i> @lang('app.dashboard')
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
