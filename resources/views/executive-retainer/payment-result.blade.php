<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $pageTitle }}</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      display: flex; align-items: center; justify-content: center;
      min-height: 100vh; background: #f5f7fa;
    }
    .card {
      background: #fff; border-radius: 16px; padding: 40px;
      text-align: center; box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      max-width: 420px; width: 90%;
    }
    .icon { font-size: 64px; margin-bottom: 16px; }
    .icon.success { color: #28a745; }
    .icon.failure { color: #dc3545; }
    h2 { font-size: 22px; color: #1a1a2e; margin-bottom: 8px; }
    p { color: #6c757d; font-size: 14px; margin-bottom: 24px; line-height: 1.6; }
    .spinner {
      width: 36px; height: 36px; border: 3px solid #e9ecef;
      border-top-color: #667eea; border-radius: 50%;
      animation: spin 0.8s linear infinite; margin: 0 auto 16px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn {
      display: inline-block; padding: 10px 24px; border-radius: 8px;
      text-decoration: none; font-size: 14px; font-weight: 600;
      background: #667eea; color: #fff; border: none; cursor: pointer;
    }
    .btn:hover { opacity: 0.9; }
  </style>
</head>
<body>
  <div class="card">
    <div class="icon {{ $status }}">@if($status === 'success')&#10003;@else&#10007;@endif</div>
    <h2>{{ $heading }}</h2>
    <p>{{ $message }}</p>
    <div class="spinner"></div>
    <p style="font-size:13px;color:#adb5bd;">Redirecting you to your applications...</p>
    <br>
    <a href="{{ $redirectUrl }}" class="btn">Go to My Applications</a>
  </div>
  <script>setTimeout(function(){ window.location.href = '{{ $redirectUrl }}'; }, 4000);</script>
</body>
</html>
