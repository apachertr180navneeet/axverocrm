@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        <i class="fa fa-edit mr-2 text-info"></i>@lang('app.edit') Application #{{ $application->id }}
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          @include('admin.executive-retainer._form', ['application' => $application])
        </div>
      </div>
    </div>
  </div>
@endsection
