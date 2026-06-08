@extends('layouts.app')

@section('content')

<div class="container-fluid py-4 px-3 px-md-4">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- Card Header --}}
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="row align-items-center g-3">

                {{-- Title --}}
                <div class="col-12 col-md-auto">
                    <h5 class="fw-bold mb-0">My Generated Letters</h5>
                    <small class="text-muted">Manage offer letters you have created.</small>
                </div>

                {{-- Search + Filters + Button --}}
                <div class="col-12 col-md ms-md-auto">
                <form method="GET" action="{{ route('letter.list') }}" class="row g-2 justify-content-md-end">

                        {{-- Search Input --}}
                        <div class="col-12 col-sm col-md-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control border-start-0 bg-light"
                                    placeholder="Search candidate..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                        </div>

                        {{-- Designation Filter --}}
                        <div class="col-6 col-sm-auto">
                            <select name="designation" class="form-select form-select-sm bg-light">
                                <option value="">All Designations</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation }}" {{ request('designation') == $designation ? 'selected' : '' }}>
                                        {{ $designation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status Filter --}}
                        <div class="col-6 col-sm-auto">
                            <select name="status" class="form-select form-select-sm bg-light">
                                <option value="">All Status</option>
                                <option value="sent"    {{ request('status') == 'sent'    ? 'selected' : '' }}>Sent</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        {{-- Filter + Clear --}}
                        <div class="col-auto d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-funnel"></i>
                                <span class="d-none d-sm-inline ms-1">Filter</span>
                            </button>
                            @if(request()->hasAny(['search', 'designation', 'status']))
                           <a href="{{ route('letter.list') }}" class="btn btn-sm btn-outline-danger" title="Clear filters">
                                <i class="bi bi-x-lg"></i>
                            </a>
                            @endif
                        </div>

                        {{-- Create Button --}}
                            @if(in_array('admin', user_roles())  || (int) user()->letter_status === 1)
                        <div class="col-auto">
                            <a href="{{ route('generate') }}" class="btn btn-sm btn-primary fw-semibold px-3">
                                <i class="bi bi-plus-lg me-1"></i>Create New Letter
                            </a>
                        </div>
                        @endif

                    </form>
                </div>

            </div>
        </div>

        {{-- Table --}}
        @if($offerLetters->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase text-muted fw-semibold small ps-4" style="font-size:11px; letter-spacing:.6px;">Candidate</th>
                        <th class="text-uppercase text-muted fw-semibold small"       style="font-size:11px; letter-spacing:.6px;">Designation</th>
                        <th class="text-uppercase text-muted fw-semibold small"       style="font-size:11px; letter-spacing:.6px;">Date</th>
                        <th class="text-uppercase text-muted fw-semibold small"       style="font-size:11px; letter-spacing:.6px;">Status</th>
                        <th class="text-uppercase text-muted fw-semibold small text-end pe-4" style="font-size:11px; letter-spacing:.6px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offerLetters as $letter)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-semibold">{{ $letter->full_name }}</span>
                            <span class="text-muted"> ({{ $letter->id }})</span>
                        </td>
                        <td class="text-muted">{{ $letter->designation }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($letter->joining_date)->format('M d, Y') }}</td>
                        <td>
                            @if($letter->status === 'sent')
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2" style="font-size:11px; letter-spacing:.4px;">
                                    ● SENT
                                </span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2" style="font-size:11px; letter-spacing:.4px;">
                                    ● PENDING
                                </span>
                            @endif
                        </td>
                      <td class="text-end pe-4">
                        <a href="{{ route('offer-letters.download', $letter->id) }}"
                           class="btn btn-link text-primary fw-semibold text-decoration-none small">
                            <i class="bi bi-download me-1"></i> Download
                        </a>
                        
                        <form action="{{ route('offer-letters.delete', $letter->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this offer letter? This action cannot be undone.')">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-link text-primary fw-semibold text-decoration-none small">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <!-- <a href="{{ route('offer-letters.delete', $letter->id) }}"-->
                        <!--   class="text-primary fw-semibold text-decoration-none small"-->
                        <!--   onclick="return confirm('Are you sure you want to delete this offer letter? This action cannot be undone.')"-->
                        <!--   >-->
                        <!--    <i class="bi bi-trash me-1"></i> Delete-->
                        <!--</a>-->
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($offerLetters->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                <small class="text-muted">
                    Showing {{ $offerLetters->firstItem() }}–{{ $offerLetters->lastItem() }}
                    of {{ $offerLetters->total() }} results
                </small>
                <div>
                    {{ $offerLetters->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif

        {{-- Empty State --}}
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-file-earmark-text display-4 d-block mb-3 opacity-25"></i>
            <p class="fw-semibold mb-1">No offer letters found.</p>
            <small>Try adjusting your search or filters.</small>
        </div>
        @endif

    </div>
</div>

@endsection