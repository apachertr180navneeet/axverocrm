@extends('layouts.app')

@section('content')

<div class="content-wrapper">
<div class="container-fluid mt-4">

<div class="card shadow-sm">

<div class="card-body">

{{-- SUCCESS --}}
@if(session('success'))
<div class="alert alert-success" id="successMessage">
    {{ session('success') }}
</div>
@endif


{{-- FILTER --}}
<form method="GET" class="row g-2 mb-3">

    <div class="col-md-3 col-12">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Search Name / Mobile">
    </div>

    <div class="col-md-2 col-6">
        <select name="gender" class="form-control">
            <option value="">Gender</option>
            <option value="Male" {{ request('gender')=='Male'?'selected':'' }}>Male</option>
            <option value="Female" {{ request('gender')=='Female'?'selected':'' }}>Female</option>
            <option value="Other" {{ request('gender')=='Other'?'selected':'' }}>Other</option>
        </select>
    </div>

    <div class="col-md-2 col-6">
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
    </div>

    <div class="col-md-2 col-6">
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
    </div>

    <div class="col-md-2 col-6 d-grid">
        <button type="button" class="btn btn-success" onclick="fetchResults()">Filter</button>
    </div>

    <div class="col-md-1 col-6 d-grid">
        <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
    </div>

</form>


{{-- TABLE --}}
<div class="table-responsive">

<table class="table table-hover table-bordered align-middle">

<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Name</th>
    <th class="d-none d-md-table-cell">Email</th>
    <th>Mobile</th>
    <th class="d-none d-md-table-cell">Gender</th>
    <th class="d-none d-md-table-cell">Joining Date</th>
    <th>Action</th>
</tr>
</thead>

<tbody id="kits-tbody">

@forelse($kits as $key => $row)

<tr>
    <td>{{ $kits->firstItem() + $key }}</td>

    <td>
        <strong>{{ $row->first_name }} {{ $row->last_name }}</strong>
        <div class="text-muted small d-md-none">
            {{ $row->email }}
        </div>
    </td>

    <td class="d-none d-md-table-cell">{{ $row->email }}</td>

    <td>{{ $row->mobile }}</td>

    <td class="d-none d-md-table-cell">{{ $row->gender }}</td>

    <td class="d-none d-md-table-cell">{{ $row->joining_date }}</td>

    <td>
        <a href="{{ route('joiningkit.pdf',$row->id) }}"
           class="btn btn-sm btn-danger">
            PDF
        </a>
    </td>
</tr>

@empty

<tr>
    <td colspan="7" class="text-center text-muted">
        No Data Found
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>


{{-- PAGINATION --}}
<div class="mt-3 d-flex justify-content-center" id="kits-pagination">
    @if($kits->hasPages())
    <div class="custom-pagination">

        {{-- Prev --}}
        <a class="pg-btn {{ $kits->onFirstPage() ? 'pg-disabled' : '' }}"
           href="{{ $kits->previousPageUrl() ?? '#' }}">&laquo;</a>

        @php
            $current  = $kits->currentPage();
            $last     = $kits->lastPage();
            $start    = max(1, $current - 2);
            $end      = min($last, $current + 2);
        @endphp

        {{-- First page --}}
        @if($start > 1)
            <a class="pg-btn" href="{{ $kits->url(1) }}">1</a>
            @if($start > 2)
                <span class="pg-btn pg-disabled">...</span>
            @endif
        @endif

        {{-- Middle pages (current ± 2) --}}
        @for($i = $start; $i <= $end; $i++)
            <a class="pg-btn {{ $current == $i ? 'pg-active' : '' }}"
               href="{{ $kits->url($i) }}">{{ $i }}</a>
        @endfor

        {{-- Last page --}}
        @if($end < $last)
            @if($end < $last - 1)
                <span class="pg-btn pg-disabled">...</span>
            @endif
            <a class="pg-btn" href="{{ $kits->url($last) }}">{{ $last }}</a>
        @endif

        {{-- Next --}}
        <a class="pg-btn {{ !$kits->hasMorePages() ? 'pg-disabled' : '' }}"
           href="{{ $kits->nextPageUrl() ?? '#' }}">&raquo;</a>

    </div>
    @endif
</div>

</div>
</div>

</div>
</div>

@endsection


@push('scripts')
<script>
// ===== SUCCESS MESSAGE AUTO HIDE =====
setTimeout(function(){
    let msg = document.getElementById('successMessage');
    if(msg) msg.style.display = 'none';
}, 3000);


// ===== FETCH RESULTS VIA AJAX =====
let debounceTimer;

function fetchResults(url) {

    // Agar url nahi diya to current filters se banao
    if (!url) {
        const search   = document.querySelector('[name="search"]').value;
        const gender   = document.querySelector('[name="gender"]').value;
        const fromDate = document.querySelector('[name="from_date"]').value;
        const toDate   = document.querySelector('[name="to_date"]').value;

        const params = new URLSearchParams({
            search    : search,
            gender    : gender,
            from_date : fromDate,
            to_date   : toDate
        });

        url = `{{ route('joiningkit.list') }}?${params.toString()}`;
    }

    // Loading indicator
    document.getElementById('kits-tbody').innerHTML = `
        <tr>
            <td colspan="7" class="text-center text-muted py-3">
                <span class="spinner-border spinner-border-sm me-2"></span> Loading...
            </td>
        </tr>`;

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(res) { return res.text(); })
    .then(function(html) {
        const parser = new DOMParser();
        const doc    = parser.parseFromString(html, 'text/html');

        // tbody update
        const newTbody = doc.getElementById('kits-tbody');
        if (newTbody) {
            document.getElementById('kits-tbody').innerHTML = newTbody.innerHTML;
        }

        // pagination update
        const newPagination = doc.getElementById('kits-pagination');
        if (newPagination) {
            document.getElementById('kits-pagination').innerHTML = newPagination.innerHTML;
        }

        // Browser URL update
        window.history.pushState({}, '', url);

        // Pagination links ko AJAX se bind karo
        bindPaginationLinks();
    })
    .catch(function(err) {
        document.getElementById('kits-tbody').innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-danger">
                    Something went wrong. Please try again.
                </td>
            </tr>`;
    });
}


// ===== DEBOUNCE — 400ms baad call =====
function debounce(fn, delay) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fn, delay);
}


// ===== RESET FILTERS =====
function resetFilters() {
    document.querySelector('[name="search"]').value   = '';
    document.querySelector('[name="gender"]').value   = '';
    document.querySelector('[name="from_date"]').value = '';
    document.querySelector('[name="to_date"]').value   = '';
    fetchResults();
}


// ===== PAGINATION LINKS — AJAX BIND =====
function bindPaginationLinks() {
    const paginationDiv = document.getElementById('kits-pagination');
    if (!paginationDiv) return;

    paginationDiv.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            fetchResults(this.href);
        });
    });
}


// ===== EVENT LISTENERS =====

// Search — type karte hi debounce se
document.querySelector('[name="search"]').addEventListener('input', function() {
    debounce(fetchResults, 400);
});

// Gender — change hote hi
document.querySelector('[name="gender"]').addEventListener('change', function() {
    fetchResults();
});

// From date — change hote hi
document.querySelector('[name="from_date"]').addEventListener('change', function() {
    fetchResults();
});

// To date — change hote hi
document.querySelector('[name="to_date"]').addEventListener('change', function() {
    fetchResults();
});


// ===== PAGE LOAD PE PAGINATION BIND =====
bindPaginationLinks();

</script>
@endpush


@push('styles')
<style>

/* MOBILE OPTIMIZATION */
@media (max-width: 768px) {

    .card-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn {
        font-size: 12px;
        padding: 6px 10px;
    }

    table td {
        font-size: 13px;
    }
}

/* CLEAN LOOK */
.table th, .table td {
    vertical-align: middle;
}

.card {
    border-radius: 10px;
}
/* ===== CUSTOM PAGINATION ===== */
.custom-pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: center;
    margin-top: 12px;
}

.pg-btn {
    display: inline-block;
    padding: 6px 12px;
    font-size: 13px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    color: #0d6efd;
    background: #fff;
    text-decoration: none;
    transition: all 0.2s;
}

.pg-btn:hover {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.pg-btn.pg-active {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
    font-weight: 600;
    pointer-events: none;
}

.pg-btn.pg-disabled {
    color: #adb5bd;
    pointer-events: none;
    background: #f8f9fa;
    border-color: #e9ecef;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .pg-btn {
        padding: 5px 9px;
        font-size: 12px;
    }

    table td {
        font-size: 13px;
    }

    .btn {
        font-size: 12px;
        padding: 6px 10px;
    }
}

/* ===== TABLE CLEAN LOOK ===== */
.table th, .table td {
    vertical-align: middle;
}

.card {
    border-radius: 10px;
}

</style>
@endpush