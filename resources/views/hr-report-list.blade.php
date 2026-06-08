            @extends('layouts.app')
            
            @section('content')
            
            <div class="container mt-4">
            
            <!--<h4 class="mb-4">HR Executive Reports</h4>-->
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Executive Report</h4>

                <a href="{{ route('hr.executive.report') }}" 
                   class="btn btn-primary btn-sm">
                   + Add New
                </a>
          
            </div>
            
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
            
            <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>HR Manager</th>
                <th>Action</th>
            </tr>
            </thead>
            
            <tbody>
            
            @forelse($reports as $report)
            <tr>
                <td>{{ $report->report_date->format('d/m/Y') }}</td>
                <td>{{ $report->name }}</td>
                <td>{{ $report->mobile }}</td>
                <td>{{ $report->hr_manager_name }}</td>
                <td>
                    <a href="{{ route('hr.executive.report.pdf',$report->id) }}"
                       class="btn btn-sm btn-primary">
                       View More
                    </a>
                </td>
            </tr>
            @empty
            <tr>
            <td colspan="5" class="text-center">No Reports Found</td>
            </tr>
            @endforelse
            
            </tbody>
            </table>
            </div>
            
            {{ $reports->links() }}
            
            </div>
            
            @endsection