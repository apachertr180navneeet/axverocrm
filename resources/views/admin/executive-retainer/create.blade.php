@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    @include('admin.executive-retainer._form', ['application' => null])
</div>
@endsection