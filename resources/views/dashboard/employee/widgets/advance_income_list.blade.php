<div class="table-container">
    <div class="section-header">
        <i class="fas fa-credit-card me-2"></i> PayU Hiring Applications
    </div>

    <div class="filter-card">
        <div class="filter-title"><i class="fas fa-filter me-2"></i> Filter PayU Applications</div>
        <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control"
                    placeholder="Search by Name, Email, Mobile, TXN ID" value="{{ request('search') }}">
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
                    <option value="success" {{ request('payment_status')=='success' ? 'selected' : '' }}>✅ Success
                    </option>
                    <option value="pending" {{ request('payment_status')=='pending' ? 'selected' : '' }}">⏳ Pending
                    </option>
                    <option value="failed" {{ request('payment_status')=='failed' ? 'selected' : '' }}">❌ Failed
                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="btn-group">
                    <button type="submit" class="btn-primary"><i class="fas fa-search me-1"></i> Search</button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary"><i class="fas fa-sync me-1"></i>
                        Reset</a>
                    <a href="{{ route('export.payu.excel', request()->query()) }}" class="btn-success"><i
                            class="fas fa-file-excel me-1"></i> Excel</a>
                    <a href="{{ route('export.payu.pdf', request()->query()) }}" class="btn-danger"><i
                            class="fas fa-file-pdf me-1"></i> PDF</a>
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