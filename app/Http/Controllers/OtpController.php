<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    public function send(Request $request)
        {

    config([
        'mail.mailers.smtp.transport' => 'smtp',
        'mail.mailers.smtp.host' => 'smtp.hostinger.com',
        'mail.mailers.smtp.port' => 465,
        'mail.mailers.smtp.encryption' => 'ssl',
        'mail.mailers.smtp.username' => 'verify@axvero.in',
        'mail.mailers.smtp.password' => 'Axvero@951',
        'mail.from.address' => 'verify@axvero.in',
        'mail.from.name' => 'Axvero',
    ]);

    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid email address.',
        ], 422);
    }

    $email = strtolower(trim($request->email));
    $otp   = rand(100000, 999999);

    Cache::put('otp_' . md5($email), [
        'otp'      => $otp,
        'email'    => $email,
        'verified' => false,
        'attempts' => 0,
    ], now()->addMinutes(10));

    try {
        Mail::html($this->otpEmailHtml($otp, $email), function ($message) use ($email) {
            $message->to($email)
                    ->subject('Your OTP for Joining Form Verification');
        });

        \Log::info('OTP SENT SUCCESSFULLY', ['email' => $email, 'otp' => $otp]);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to ' . $email,
        ]);

    } catch (\Exception $e) {
        \Log::error('OTP MAIL ERROR: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Mail error: ' . $e->getMessage(),
        ], 500);
    }
}

    public function verify(Request $request)
    {
        \Log::info('OTP VERIFY CALLED', ['email' => $request->email]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 6-digit OTP.',
            ], 422);
        }

        $email    = strtolower(trim($request->email));
        $cacheKey = 'otp_' . md5($email);
        $data     = Cache::get($cacheKey);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired. Please request a new OTP.',
            ], 400);
        }

        if ($data['attempts'] >= 5) {
            Cache::forget($cacheKey);
            return response()->json([
                'success' => false,
                'message' => 'Too many attempts. Please request a new OTP.',
            ], 429);
        }

        if ((string)$data['otp'] !== (string)$request->otp) {
            $data['attempts']++;
            Cache::put($cacheKey, $data, now()->addMinutes(10));
            return response()->json([
                'success' => false,
                'message' => 'Incorrect OTP. ' . (5 - $data['attempts']) . ' attempt(s) remaining.',
            ], 400);
        }

        $data['verified'] = true;
        Cache::put($cacheKey, $data, now()->addMinutes(30));

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!',
        ]);
    }

    public static function isVerified(string $email): bool
    {
        $data = Cache::get('otp_' . md5(strtolower($email)));
        return $data && $data['verified'] === true;
    }

    private function otpEmailHtml(int $otp, string $email): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>OTP</title></head>
<body style="margin:0;padding:0;background:#0f172a;font-family:Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
    <tr><td align="center">
      <table width="520" cellpadding="0" cellspacing="0"
             style="background:#1e293b;border-radius:16px;border:1px solid #2d3a4b;overflow:hidden;">
        <tr>
          <td style="background:linear-gradient(135deg,#3b82f6,#a855f7);padding:30px;text-align:center;">
            <h1 style="margin:0;color:#fff;font-size:22px;">Axvero</h1>
            <p style="margin:6px 0 0;color:rgba(255,255,255,0.8);font-size:14px;">Joining Agreement Kit — Email Verification</p>
          </td>
        </tr>
        <tr>
          <td style="padding:36px 40px;">
            <p style="color:#94a3b8;font-size:15px;margin:0 0 20px;">Hello, <strong style="color:#e2e8f0;">{$email}</strong></p>
            <div style="background:#0B1220;border:2px dashed #3b82f6;border-radius:14px;padding:24px;text-align:center;margin:0 0 28px;">
              <p style="margin:0 0 8px;color:#64748b;font-size:12px;letter-spacing:2px;">YOUR ONE-TIME PASSWORD</p>
              <div style="font-size:42px;font-weight:800;letter-spacing:12px;color:#a5b4fc;">{$otp}</div>
              <p style="margin:10px 0 0;color:#64748b;font-size:12px;">Valid for <strong style="color:#f59e0b;">10 minutes</strong> only</p>
            </div>
            <p style="color:#64748b;font-size:13px;">Do not share this OTP with anyone.</p>
          </td>
        </tr>
        <tr>
          <td style="background:#0f172a;padding:20px;border-top:1px solid #2d3a4b;text-align:center;">
            <p style="margin:0;color:#475569;font-size:12px;">© Axvero | verify@axvero.in</p>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
    }
}