@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <x-app-title class="d-block d-lg-none" :pageTitle="$pageTitle"></x-app-title>
        <h4 class="f-21 f-w-500 mb-0 d-none d-lg-block">{{ $pageTitle }}</h4>
    </div>

    @php $showPayment = false; @endphp
    @include('executive-retainer._form')
</div>
@endsection
