<form name="payuForm" action="{{config('services.payu.url')}}" method="POST">
  <input type="hidden" name="key" value="{{ $key }}">
  <input type="hidden" name="txnid" value="{{ $application->txnid }}">
  <input type="hidden" name="amount" value="{{ $application->amount }}">
  <input type="hidden" name="productinfo" value="Executive Retainer Fee">
  <input type="hidden" name="firstname" value="{{ $user->name }}">
  <input type="hidden" name="email" value="{{ $user->email }}">
  <input type="hidden" name="hash" value="{{ $hash }}">
  <input type="hidden" name="surl" value="{{ route('executive-retainer.payment.success') }}">
  <input type="hidden" name="furl" value="{{ route('executive-retainer.payment.failure') }}">
</form>
<script>document.payuForm.submit();</script>