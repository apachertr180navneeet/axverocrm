        @extends('layouts.app')
        
        @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <style>
        .table-responsive {
            overflow-x: auto;
        }
        </style>
        @endpush
        
        
        @section('content')
        <div class="content-wrapper">
        <div class="container-fluid">
        
        <div class="bg-white p-4 rounded">
        
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h4 class="mb-2">{{ $pageTitle ?? 'Report Manager' }}</h4>
                <a href="{{ route('dailyreport') }}" class="btn btn-primary btn-sm">
                        + Create New
                        </a>
            
            </div>
        
            {{-- Success Message --}}
            @if(session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
        
            {{-- Reports Table --}}
<div class="d-none d-md-block">
    {{-- Desktop Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <!--<th>Total Sales Executive</th>-->
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $key => $report)
                <tr>
                    <td>{{ $reports->firstItem() + $key }}</td>
                    <td>{{ $report->report_date }}</td>
                    <td>{{ $report->portal_email }}</td>
                    <td>{{ $report->name }}</td>
                    <td>{{ $report->mobile }}</td>
                    <!--<td>{{ $report->total_joined_retainer }}</td>-->
                    <td>
                        <a href="{{ route('daily-report.pdf', $report->id) }}"
                           class="btn btn-secondary btn-sm">
                           PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No reports found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- Mobile View Card Layout --}}
<div class="d-block d-md-none">
    @forelse($reports as $key => $report)
        <div class="card mb-3 shadow-sm">
            <div class="card-body p-3">

                <p class="mb-1"><strong>Date:</strong><br>
                    {{ $report->report_date }}
                </p>

                <p class="mb-1"><strong>Email:</strong><br>
                    {{ $report->portal_email }}
                </p>

                <p class="mb-1"><strong>Name:</strong><br>
                    {{ $report->name }}
                </p>

                <p class="mb-1"><strong>Mobile:</strong><br>
                    {{ $report->mobile }}
                </p>

                <p class="mb-2"><strong>Total Retainer:</strong><br>
                    {{ $report->total_joined_retainer }}
                </p>

                <a href="{{ route('daily-report.pdf', $report->id) }}"
                   class="btn btn-secondary btn-block">
                   Download PDF
                </a>

            </div>
        </div>
    @empty
        <div class="text-center">No reports found</div>
    @endforelse
</div>
        
            {{-- Pagination --}}
            <div class="mt-3">
                {{ $reports->links() }}
            </div>
        
        </div>
        </div>
        </div>
        @endsection
        
        
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
        $(document).ready(function() {
            setTimeout(function() {
                let alertBox = $('#success-alert');
                if(alertBox.length){
                    alertBox.fadeOut('slow');
                }
            }, 3000);
        });
        </script>
        @endpush