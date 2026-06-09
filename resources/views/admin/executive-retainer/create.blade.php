@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        <i class="fa fa-plus mr-2 text-primary"></i>@lang('app.add') Advance Income Form
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          @include('admin.executive-retainer._form', ['application' => null])
        </div>
      </div>
    </div>
  </div>
@endsection
