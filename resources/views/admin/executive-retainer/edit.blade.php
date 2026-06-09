@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    @include('admin.executive-retainer._form', ['application' => $application])
</div>
@endsection