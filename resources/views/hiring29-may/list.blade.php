@extends('layouts.app')
@push('styles')
  <style>
      .advance-income .btn-group {
          display: flex;
          gap: 8px;
          flex-wrap: wrap;
      }
      .advance-income .btn-sm {
          padding: 6px 12px;
          font-size: 12px;
      }
      .advance-income .filter-card {
          background: #f8f9fa;
          border-radius: 12px;
          padding: 20px;
          margin-bottom: 20px;
      }
      .advance-income .filter-title {
          font-size: 16px;
          font-weight: 600;
          margin-bottom: 15px;
          color: #333;
      }
      .advance-income .btn-primary {
          background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
          border: none;
          color: white;
          padding: 8px 20px;
          border-radius: 8px;
          cursor: pointer;
          transition: all 0.3s;
      }
      .advance-income .btn-primary:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
      }
      .advance-income .btn-secondary {
          background: linear-gradient(135deg, #64748b 0%, #475569 100%);
          border: none;
          color: #fff !important;
          padding: 8px 20px;
          border-radius: 8px;
          cursor: pointer;
          transition: all 0.3s;
          text-decoration: none;
          display: inline-block;
      }
      .advance-income .btn-secondary:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
          color: white;
      }
      .advance-income .btn-success {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          border: none;
          color: white;
          padding: 8px 20px;
          border-radius: 8px;
          cursor: pointer;
          transition: all 0.3s;
          text-decoration: none;
          display: inline-block;
      }
      .advance-income .btn-success:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
          color: white;
      }
      .advance-income .btn-danger {
          background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
          border: none;
          color: white;
          padding: 8px 20px;
          border-radius: 8px;
          cursor: pointer;
          transition: all 0.3s;
          text-decoration: none;
          display: inline-block;
      }
     .advance-income .btn-danger:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
          color: white;
      }
      .advance-income .btn-warning {
          background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
          border: none;
          color: white;
          padding: 8px 20px;
          border-radius: 8px;
          cursor: pointer;
          transition: all 0.3s;
          text-decoration: none;
          display: inline-block;
      }
      .advance-income .btn-warning:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
          color: white;
      }
      .advance-income .stats-card {
          background: white;
          border-radius: 16px;
          padding: 20px;
          margin-bottom: 20px;
          box-shadow: 0 2px 8px rgba(0,0,0,0.05);
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
      .advance-income .stats-info .card-title {
          font-size: 14px;
          color: #666;
          margin-bottom: 5px;
      }
      .advance-income .stats-info .card-value {
          font-size: 28px;
          font-weight: bold;
          color: #333;
      }
      .advance-income .card-icon {
          width: 50px;
          height: 50px;
          border-radius: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .advance-income .table-container {
          background: white;
          border-radius: 16px;
          padding: 20px;
          margin-bottom: 30px;
          box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      }
      .advance-income .section-header {
          font-size: 18px;
          font-weight: 600;
          margin-bottom: 20px;
          padding-bottom: 10px;
          border-bottom: 2px solid #667eea;
      }
      .advance-income .status-paid {
          background: #10b981;
          color: white;
          padding: 4px 12px;
          border-radius: 20px;
          font-size: 12px;
      }
      .advance-income .status-pending {
          background: #f59e0b;
          color: white;
          padding: 4px 12px;
          border-radius: 20px;
          font-size: 12px;
      }
      .advance-income .status-failed {
          background: #ef4444;
          color: white;
          padding: 4px 12px;
          border-radius: 20px;
          font-size: 12px;
      }
      .advance-income table {
          width: 100%;
          border-collapse: collapse;
      }
      .advance-income th, td {
          padding: 12px;
          text-align: left;
          border-bottom: 1px solid #eee;
      }
      .advance-income th {
          background: #f8f9fa;
          font-weight: 600;
      }
      .advance-income .pagination {
          margin-top: 20px;
          display: flex;
          justify-content: center;
          gap: 5px;
      }
      .advance-income .pagination .page-link {
          padding: 8px 12px;
          border: 1px solid #ddd;
          border-radius: 6px;
          text-decoration: none;
          color: #333;
      }
      .advance-income .pagination .active .page-link {
          background: #667eea;
          color: white;
          border-color: #667eea;
      }
  </style>
@endpush
@section('content')
  <div class="container-fluid advance-income">
          <div class="table-container">
          <div class="section-header">
              <i class="fas fa-credit-card me-2"></i> PayU Hiring Applications
          </div>

          <div class="filter-card">
              <div class="filter-title"><i class="fas fa-filter me-2"></i> Filter PayU Applications</div>
              <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                  <div class="col-md-3">
                      <input type="text" name="search" class="form-control" placeholder="Search by Name, Email, Mobile, TXN ID" value="{{ request('search') }}">
                  </div>
                  <div class="col-md-2">
                      <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                  </div>
                  <div class="col-md-2">
                      <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                  </div>
                  <div class="col-md-2">
                      <select name="payment_status" class="form-control">
                          <option value="">All Status</option>
                          <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>✅ Success</option>
                          <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}">⏳ Pending</option>
                          <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}">❌ Failed</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <div class="btn-group">
                          <button type="submit" class="btn-primary"><i class="fas fa-search me-1"></i> Search</button>
                          <a href="{{ route('dashboard') }}" class="btn-secondary"><i class="fas fa-sync me-1"></i> Reset</a>
                          <a href="{{ route('export.payu.excel', request()->query()) }}" class="btn-success"><i class="fas fa-file-excel me-1"></i> Excel</a>
                          <a href="{{ route('export.payu.pdf', request()->query()) }}" class="btn-danger"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                      </div>
                  </div>
              </form>
          </div>

          <div class="table-responsive">
              <table class="table">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Mobile</th>
                          <th>Email</th>
                          <th>Designation</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Date</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse($hiringSubmissions as $submission)
                        <tr>
                            <td>#{{ $submission->id }}</td>
                            <td><strong>{{ $submission->name }}</strong></td>
                            <td>{{ $submission->mobile }}</td>
                            <td>{{ $submission->email }}</td>
                            <td>{{ $submission->designation }}</td>
                            <td>₹{{ number_format($submission->amount, 2) }}</td>
                            <td>
                                @if($submission->payment_status == 'success')
                                  <span class="status-paid">✅ PAID</span>
                                @elseif($submission->payment_status == 'pending')
                                  <span class="status-pending">⏳ PENDING</span>
                                @else
                                  <span class="status-failed">❌ FAILED</span>
                                @endif
                            </td>
                            <td>{{ $submission->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                      @empty
                        <tr>
                            <td colspan="8" class="text-center">No PayU applications found</td>
                        </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
          {{ $hiringSubmissions->appends(request()->query())->links() }}
      </div>
  </div>
@push('scripts')

@endpush
@endsection