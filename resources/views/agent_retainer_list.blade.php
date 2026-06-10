        @extends('layouts.app')
        
@section('content')
<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <x-app-title class="d-block d-lg-none" :pageTitle="$pageTitle"></x-app-title>
        <h4 class="f-21 f-w-500 mb-0 d-none d-lg-block">{{ $pageTitle }}</h4>
        <div class="d-flex">
            <a href="{{ route('agent_retainer.create') }}" class="btn btn-primary rounded f-14 p-2 mr-2">
                <i class="fa fa-plus mr-1"></i> Add Retainer
            </a>
            @if(in_array('admin', user_roles()))
            <a href="{{ route('agent_retainer.export-excel', request()->query()) }}" class="btn btn-secondary rounded f-14 p-2">
                <i class="fa fa-file-export mr-1"></i> Export Excel
            </a>
            @endif
        </div>
    </div>

<div class="card">
<div class="card-body">
        
        
        {{-- success message --}}
        @if(session('success'))
        <div class="alert alert-success" id="successMessage">
        {{ session('success') }}
        </div>
        @endif
        
        
        {{-- filters --}}
        <form method="GET" class="row mb-3">
        
        <div class="col-md-3 mb-2">
        <input type="text"
        name="search"
        value="{{ request('search') }}"
        class="form-control"
        placeholder="Search Name / Mobile">
        </div>
        
        <div class="col-md-2 mb-2">
        <select name="gender" class="form-control">
        
        <option value="">Gender</option>
        
        <option value="Male" {{ request('gender')=='Male'?'selected':'' }}>
        Male
        </option>
        
        <option value="Female" {{ request('gender')=='Female'?'selected':'' }}>
        Female
        </option>
        
        <option value="Other" {{ request('gender')=='Other'?'selected':'' }}>
        Other
        </option>
        
        </select>
        </div>
        
        <div class="col-md-2 mb-2">
        <input type="date"
        name="from_date"
        value="{{ request('from_date') }}"
        class="form-control"
        placeholder="From Created Date">
        </div>
        
        <div class="col-md-2 mb-2">
        <input type="date"
        name="to_date"
        value="{{ request('to_date') }}"
        class="form-control"
        placeholder="To Created Date">
        </div>
        
        <div class="col-md-2 mb-2">
        <button class="btn btn-success">
        Filter
        </button>
        </div>
        
        <div class="col-md-1 mb-2">
        <a href="{{ route('agent_retainer.list') }}" class="btn btn-secondary">
        Reset
        </a>
        </div>
        
        </form>
        
        
        <div class="table-responsive">
        
        <table class="table table-bordered table-hover">
        
        <thead>
        
        <tr>
        
        <th>#</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Gender</th>
        <th>DOB</th>
        <th>Created At</th>
        <th width="120">Action</th>
        
        </tr>
        
        </thead>
        
        <tbody>
        
        @forelse($agentRetainers as $key => $row)
        
        <tr>
        
        <td>{{ $agentRetainers->firstItem() + $key }}</td>
        
        <td>{{ $row->name }}</td>
        
        <td>{{ $row->mobile }}</td>
        
        <td>{{ $row->gender }}</td>
        
        <td>{{ $row->date_of_birth }}</td>
        
        <td>{{ $row->created_at->format('d-m-Y') }}</td>
        
        <td>
        
        <a href="{{ route('agent_retainer.pdf',$row->id) }}"
        class="btn btn-danger btn-sm btn-pdf">
        
        PDF
        
        </a>
        
        </td>
        
        </tr>
        
        @empty
        
        <tr>
        
        <td colspan="7" class="text-center">
        No Data Found
        </td>
        
        </tr>
        
        @endforelse
        
        </tbody>
        
        </table>
        
        </div>
        
        
        <div class="mt-3">
      {{ $agentRetainers->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
        </div>
        
        </div>
        
        </div>
        
        </div>
        
        </div>
        
        @endsection
        
        
        @push('scripts')
        
        <script>
        
        setTimeout(function(){
        
        let msg = document.getElementById('successMessage');
        
        if(msg){
        
        msg.style.display = 'none';
        
        }
        
        },3000);
        
        </script>
        
        @endpush
        @push('styles')
    
    <style>
    
    .btn-pdf{
    background:#dc3545;
    color:#fff !important;
    border-color:#dc3545;
    }
    
    .btn-pdf:hover{
    background:#000;
    color:#fff !important;
    border-color:#000;
    }
    
    </style>

@endpush