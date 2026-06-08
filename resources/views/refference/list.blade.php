@extends('layouts.app')

@section('content')
<div class="container mt-3">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h3 class="mb-2">Report Manager</h3>

        <a href="{{ route('refference.create') }}" class="btn btn-danger btn-sm">
            + Create New
        </a>
    </div>

    {{-- SEARCH (SMALL) --}}
    <div class="mb-3">
        <input type="text" id="search" class="form-control search-box" placeholder="Search...">
    </div>

    {{-- TABLE --}}
    <div id="table-data">
        @include('refference.list_table')
    </div>

</div>
@endsection


@push('styles')
<style>
/* Small search box */
.search-box {
    max-width: 250px;
}

/* Table look like screenshot */
.table-simple {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-simple th {
    background: #dcdcdc;
    padding: 10px;
    text-align: left;
    border: 1px solid #ccc;
}

.table-simple td {
    padding: 10px;
    border: 1px solid #ddd;
}

/* PDF button */
.pdf-btn {
    padding: 4px 10px;
    border: 1px solid #999;
    background: #f5f5f5;
    border-radius: 4px;
    font-size: 12px;
    text-decoration: none;
    color: #333;
}

/* Mobile responsive */
@media (max-width: 768px) {

    .search-box {
        max-width: 100%;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table-simple {
        min-width: 600px;
    }
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let delayTimer;

    const searchInput = document.getElementById('search');

    if (!searchInput) return;

    searchInput.addEventListener('keyup', function() {
        clearTimeout(delayTimer);

        delayTimer = setTimeout(() => {
            fetchData(1);
        }, 400);
    });

    function fetchData(page = 1) {
        let search = searchInput.value;

        fetch(`?page=${page}&search=${encodeURIComponent(search)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('table-data').innerHTML = html;
        });
    }

    // Pagination AJAX
    document.addEventListener('click', function(e) {
        let link = e.target.closest('.pagination a');

        if (link) {
            e.preventDefault();

            let url = new URL(link.href);
            let page = url.searchParams.get('page');

            fetchData(page);
        }
    });

});
</script>
@endpush