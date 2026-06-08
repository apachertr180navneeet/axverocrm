@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        <i class="fa fa-list mr-2 text-primary"></i>@lang('app.myApplications')
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover border-0 w-100">
              <thead>
                <tr>
                  <th>@lang('app.id')</th>
                  <th>@lang('app.name')</th>
                  <th>@lang('app.post')</th>
                  <th>@lang('app.joiningDate')</th>
                  <th>@lang('app.amount')</th>
                  <th>@lang('app.paymentStatus')</th>
                  <th>@lang('app.date')</th>
                </tr>
              </thead>
              <tbody>
                @forelse($applications as $app)
                  <tr>
                    <td>{{ $app->id }}</td>
                    <td>{{ $app->name }}</td>
                    <td>{{ $app->post }}</td>
                    <td>{{ $app->date_of_joining->format('d-m-Y') }}</td>
                    <td>₹{{ number_format($app->amount, 2) }}</td>
                    <td>
                      <span class="badge badge-{{ $app->payment_status == 'success' ? 'success' : ($app->payment_status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($app->payment_status) }}
                      </span>
                    </td>
                    <td>{{ $app->created_at->format('d-m-Y H:i') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                      @lang('messages.noApplications')
                      <a href="{{ route('executive-retainer.create') }}" class="btn btn-primary btn-sm ml-2">@lang('app.applyNow')</a>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            {{ $applications->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
