@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        @lang('app.menu.executiveRetainerList')
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          <form method="GET" class="mb-3">
            <div class="d-flex flex-wrap align-items-center">
              <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey">
                <input type="text" name="search" class="form-control f-14" placeholder="Name / Mobile / Email"
                  value="{{ request('search') }}">
              </div>
              <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey">
                <div class="select-status">
                  <select name="post" class="form-control select-picker">
                    <option value="">@lang('app.all') Posts</option>
                    <option value="HR Executive" {{ request('post') == 'HR Executive' ? 'selected' : '' }}>HR Executive</option>
                    <option value="Retainer" {{ request('post') == 'Retainer' ? 'selected' : '' }}>Retainer</option>
                  </select>
                </div>
              </div>
              <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey">
                <div class="select-status">
                  <select name="payment_status" class="form-control select-picker">
                    <option value="">@lang('app.all') Payment</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>@lang('app.pending')</option>
                    <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>@lang('app.success')</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>@lang('app.failed')</option>
                  </select>
                </div>
              </div>
              <div class="d-flex py-1 px-lg-2 px-md-2 px-0">
                <button type="submit" class="btn btn-primary rounded f-14 p-2 mr-2">
                  <i class="fa fa-search mr-1"></i> @lang('app.filter')
                </button>
                @if(request()->anyFilled(['search', 'post', 'payment_status']))
                  <a href="{{ route('admin.executive-retainer.index') }}" class="btn btn-secondary rounded f-14 p-2">
                    <i class="fa fa-times-circle mr-1"></i> @lang('app.clearFilters')
                  </a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="row p-20">
        <div class="col-sm-12">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div id="table-actions">
              <a href="{{ route('admin.executive-retainer.create') }}" class="btn btn-primary rounded f-14 p-2">
                <i class="fa fa-plus mr-1"></i> @lang('app.add') Application
              </a>
              @if(request()->has('trashed'))
                <a href="{{ route('admin.executive-retainer.index') }}" class="btn btn-secondary rounded f-14 p-2">
                  <i class="fa fa-list mr-1"></i> @lang('app.all') Records
                </a>
              @else
                <a href="?trashed=1" class="btn btn-secondary rounded f-14 p-2">
                  <i class="fa fa-trash-restore mr-1"></i> @lang('app.trashed')
                </a>
              @endif
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover border-0 w-100">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>@lang('app.name')</th>
                  <th>@lang('app.mobile')</th>
                  <th>@lang('app.post')</th>
                  <th>@lang('app.joiningDate')</th>
                  <th>@lang('app.amount')</th>
                  <th>@lang('app.paymentStatus')</th>
                  <th width="220">@lang('app.action')</th>
                </tr>
              </thead>
              <tbody>
                @forelse($applications as $app)
                  <tr>
                    <td>{{ $app->id }}</td>
                    <td><strong>{{ $app->name }}</strong><br><small class="text-muted">{{ $app->email }}</small></td>
                    <td>{{ $app->mobile }}</td>
                    <td>{{ $app->post }}</td>
                    <td>{{ $app->date_of_joining->format('d-m-Y') }}</td>
                    <td>₹{{ number_format($app->amount, 2) }}</td>
                    <td>
                      <span class="badge badge-{{ $app->payment_status == 'success' ? 'success' : ($app->payment_status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($app->payment_status) }}
                      </span>
                    </td>
                    <td>
                      @if($app->trashed())
                        <button class="btn btn-sm btn-success restore-btn rounded f-12 p-1" data-id="{{ $app->id }}"><i class="fa fa-undo"></i> @lang('app.restore')</button>
                        <button class="btn btn-sm btn-dark force-delete-btn rounded f-12 p-1" data-id="{{ $app->id }}"><i class="fa fa-trash-alt"></i> @lang('app.forceDelete')</button>
                      @else
                        <a href="{{ route('admin.executive-retainer.edit', $app->id) }}" class="btn btn-sm btn-info rounded f-12 p-1"><i class="fa fa-edit"></i> @lang('app.edit')</a>
                        <button class="btn btn-sm btn-danger delete-btn rounded f-12 p-1" data-id="{{ $app->id }}" data-name="{{ $app->name }}"><i class="fa fa-trash"></i> @lang('app.delete')</button>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted">@lang('messages.noRecordFound')</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            {{ $applications->appends(request()->query())->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function () {
      $('.delete-btn').click(function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        Swal.fire({
          title: '@lang('messages.sweetAlertTitle')',
          text: `@lang('messages.deleteConfirmation') ${name}?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: '@lang('app.yes')',
          cancelButtonText: '@lang('app.cancel')',
          customClass: { confirmButton: 'btn btn-primary mr-3', cancelButton: 'btn btn-secondary' },
          showClass: { popup: 'swal2-noanimation', backdrop: 'swal2-noanimation' },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/account/executive-retainer/${id}`,
              type: 'POST',
              data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
              success: function (response) {
                if (response.status == 'success') { location.reload(); }
              }
            });
          }
        });
      });

      $('.restore-btn').click(function () {
        let id = $(this).data('id');
        Swal.fire({
          title: '@lang('app.restore')?',
          text: "@lang('messages.restoreConfirmation')",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '@lang('app.yes')',
          cancelButtonText: '@lang('app.cancel')',
          customClass: { confirmButton: 'btn btn-primary mr-3', cancelButton: 'btn btn-secondary' },
          showClass: { popup: 'swal2-noanimation', backdrop: 'swal2-noanimation' },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/account/executive-retainer/${id}/restore`,
              type: 'POST',
              data: { _token: '{{ csrf_token() }}' },
              success: function (response) {
                if (response.status == 'success') { location.reload(); }
              }
            });
          }
        });
      });

      $('.force-delete-btn').click(function () {
        let id = $(this).data('id');
        Swal.fire({
          title: '@lang('app.forceDelete')?',
          text: "@lang('messages.forceDeleteConfirmation')",
          icon: 'error',
          showCancelButton: true,
          confirmButtonText: '@lang('app.yes')',
          cancelButtonText: '@lang('app.cancel')',
          customClass: { confirmButton: 'btn btn-primary mr-3', cancelButton: 'btn btn-secondary' },
          showClass: { popup: 'swal2-noanimation', backdrop: 'swal2-noanimation' },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/account/executive-retainer/${id}/force-delete`,
              type: 'POST',
              data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
              success: function (response) {
                if (response.status == 'success') { location.reload(); }
              }
            });
          }
        });
      });
    });
  </script>
@endpush
