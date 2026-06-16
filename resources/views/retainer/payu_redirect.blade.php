<form name="payuForm" action="{{config('services.payu.url')}}" method="POST">
  <input type="hidden" name="key" value="{{ $key }}">
  <input type="hidden" name="txnid" value="{{ $submission->txnid }}">
  <input type="hidden" name="amount" value="{{ $submission->amount }}">
  <input type="hidden" name="productinfo" value="Form Payment">
  <input type="hidden" name="firstname" value="{{ $user->name }}">
  <input type="hidden" name="email" value="{{ $user->email }}">
  <input type="hidden" name="hash" value="{{ $hash }}">
  <input type="hidden" name="surl" value="{{ route('payu.success') }}">
  <input type="hidden" name="furl" value="{{ route('payu.failure') }}">
</form>

<script>
  document.payuForm.submit();
</script>