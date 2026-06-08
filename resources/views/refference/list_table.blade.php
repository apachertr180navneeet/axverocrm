<div class="table-responsive">

<table class="table-simple">
    <thead>
        <tr>
            <th>#</th>
            <th>Senior Name</th>
            <th>Mobile</th>
            <th>Portal ID</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

    @forelse($refferences as $row)

        <tr>
            <td>
                {{ ($refferences->currentPage() - 1) * $refferences->perPage() + $loop->iteration }}
            </td>

            <td>{{ $row->senior_name }}</td>

            <td>{{ $row->senior_mobile }}</td>

            <td>{{ $row->user_id }}</td>

            <td>
                <a href="{{ route('refference.pdf', $row->id) }}" target="_blank" class="pdf-btn">
                    PDF
                </a>
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="5">No data found</td>
        </tr>
    @endforelse

    </tbody>
</table>

</div>

{{-- Pagination --}}
@if($refferences->hasPages())
<div class="mt-2">
    {{ $refferences->links() }}
</div>
@endif