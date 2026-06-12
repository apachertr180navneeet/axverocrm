<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferLetter;
use App\Mail\OfferLetterMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class OfferLetterController extends AccountBaseController
{
    
    

    // ── Hardcoded SMTP config ─────────────────────────────────────────────────
    private array $smtpConfig = [
        // 'mailer'    => 'sendmail',
        'host'      => 'smtp.hostinger.com',
        'port'      => 465,
        'username'  => 'hr@axvero.in',
        'password'  => 'Axvero@2026#$&@',
        'from'      => 'hr@axvero.in',
        'from_name' => 'Axvero Hr',
    ];




    private function checkOfferLetterAccess()
{
    if (!auth()->check()) {
        abort(403, 'Unauthorized');
    }

    // Admin → full access
    if (in_array('admin', user_roles())) {
        return true;
    }

    // Non-admin → only if letter_status = 1
    if ((int) user()->letter_status !== 1) {
        abort(403, 'Access denied: Offer Letter not enabled');
    }

    return true;
}




    public function generate()
    {
        $this->checkOfferLetterAccess();

        $this->pageTitle = "Generate New Offer Letter";
        $this->user = user();

        return view('offer-letter.generate', $this->data);
    }

    public function store(Request $request)
    {
          $this->checkOfferLetterAccess();
        $request->validate([
            'gender'       => 'required|in:Male,Female,Other',
            'full_name'    => 'required|string|max:150',
            'email'        => 'required|email|unique:offer_letters,email',
            'designation'  => 'required|string|max:100',
            'salary'       => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'employment_type'=>'required'
        ]);

        // Pehle pending status ke saath save karo
        $offer = OfferLetter::create([
            'user_id'      => user()->id,
            'gender'       => $request->gender,
            'full_name'    => $request->full_name,
            'email'        => $request->email,
            'designation'  => $request->designation,
            'employment_type'  => $request->employment_type,
            'salary'       => $request->salary,
            'joining_date' => $request->joining_date,
            'status'       => 'pending',
        ]);

        try {
            // PDF bytes generate karo
            $pdfContent = $this->buildPdf($offer)->output();

            // Mailer banao aur mail bhejo
            $mailer = $this->buildMailer();

            $mailable = new OfferLetterMail(
                $offer,
                $this->getPrefix($offer->gender),
                $pdfContent
            );
            $mailable->from(
                $this->smtpConfig['from'],
                $this->smtpConfig['from_name']
            );

            $mailer->to($offer->email)->send($mailable);

            // Mail gayi — status sent karo
            $offer->update(['status' => 'sent']);

            return redirect()
                ->back()
                ->with('success', 'Offer Letter generated and sent to ' . $offer->email . ' successfully!');

        } catch (\Exception $e) {
            // Mail fail — status pending rahegi
            return redirect()
                ->back()
                ->with('warning', 'Offer Letter saved but email could not be sent: ' . $e->getMessage());
        }
    }









    
    
    
    
    public function index(Request $request)
{
      $this->checkOfferLetterAccess();

    $this->pageTitle = "My Generated Letters";

    $query = OfferLetter::query();

    // 🔥 MAIN LOGIC
      if (!in_array('admin', user_roles())) {
        $query->where('user_id', user()->id);
        }

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('full_name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('designation')) {
        $query->where('designation', $request->designation);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $this->offerLetters = $query->latest()->paginate(10);

    $this->designations = OfferLetter::select('designation')
        ->distinct()
        ->pluck('designation');

    return view('offer-letter.list', $this->data);
}


    // public function downloadLetterPdf($id)
    // {
    //     $offer = OfferLetter::findOrFail($id);
    //     return $this->buildPdf($offer)
    //         ->download('Appointment_Letter_' . str_replace(' ', '_', $offer->full_name) . '.pdf');
    // }



        public function downloadLetterPdf($id)
{
         $this->checkOfferLetterAccess();
    $offer = OfferLetter::findOrFail($id);

    // 🔒 HR only own, Admin all
    if (!in_array('admin', user_roles()) && $offer->user_id != user()->id) {
        abort(403, 'Unauthorized access');
    }

    return $this->buildPdf($offer)
        ->download('Appointment_Letter_' . str_replace(' ', '_', $offer->full_name) . '.pdf');
}


    public function resendLetter($id)
    {
        $this->checkOfferLetterAccess();

        $offer = OfferLetter::findOrFail($id);

        if (!in_array('admin', user_roles()) && $offer->user_id != user()->id) {
            abort(403, 'Unauthorized access');
        }

        try {
            $pdfContent = $this->buildPdf($offer)->output();

            $mailer = $this->buildMailer();

            $mailable = new OfferLetterMail(
                $offer,
                $this->getPrefix($offer->gender),
                $pdfContent
            );
            $mailable->from(
                $this->smtpConfig['from'],
                $this->smtpConfig['from_name']
            );

            $mailer->to($offer->email)->send($mailable);

            $offer->update(['status' => 'sent']);

            return redirect()
                ->back()
                ->with('success', 'Offer Letter resent to ' . $offer->email . ' successfully!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to resend email: ' . $e->getMessage());
        }
    }

    public function previewLetter(Request $request)
    {
         $this->checkOfferLetterAccess();
        $request->validate([
            'gender'       => 'required|in:Male,Female,Other',
            'full_name'    => 'required|string|max:150',
            'email'        => 'required|email',
            'employment_type' => 'required|in:Internship,Employee',
            'designation'  => 'required|string|max:100',
            'salary'       => 'required|numeric|min:0',
            'joining_date' => 'required|date',
        ]);

        $offer         = new OfferLetter($request->only([
            'gender', 'full_name', 'email','employment_type','designation', 'salary', 'joining_date'
        ]));
        $offer->ref_no = 'PREVIEW';

        return $this->buildPdf($offer)->stream('Preview_Offer_Letter.pdf');
    }


    // ── Build dedicated mailer (Transport directly pass karo) ─────────────────
    private function buildMailer(): Mailer
    {
        // EsmtpTransport directly — SymfonyMailer wrapper nahi
        $transport = new EsmtpTransport(
            $this->smtpConfig['host'],
            $this->smtpConfig['port'],
            true  // SSL
        );
        $transport->setUsername($this->smtpConfig['username']);
        $transport->setPassword($this->smtpConfig['password']);

        // Illuminate\Mail\Mailer ko TransportInterface chahiye — seedha transport pass karo
        return new Mailer(
            'kactto_smtp',
            app('view'),
            $transport,       // ← seedha transport, SymfonyMailer nahi
            app('events')
        );
    }


    // ── Build PDF ─────────────────────────────────────────────────────────────
    private function buildPdf(OfferLetter $offer)
    {
        return Pdf::loadView('offer-letter.letter-pdf', [
            'offer'        => $offer,
            'prefix'       => $this->getPrefix($offer->gender),
            'salary_words' => $this->numberToWords((int) $offer->salary),
            'today'        => now()->format('d/F/Y'),
            'joining_fmt'  => \Carbon\Carbon::parse($offer->joining_date)->format('d F Y'),
            'logo_b64'     => $this->imgBase64(public_path('images/axvero-logo-white.jpeg')),
            'stamp_b64'    => $this->imgBase64(public_path('images/axvero-stamp.png')),
            'header_b64'   => $this->imgBase64(public_path('images/kactto-header.jpg')),
            'footer_b64'   => $this->imgBase64(public_path('images/axvero-footer.png')),
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont'          => 'DejaVu Sans',
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
            'dpi'                  => 150,
        ]);
    }
    
    public function edit($id)
    {
        $this->checkOfferLetterAccess();

        $offer = OfferLetter::findOrFail($id);

        if (!in_array('admin', user_roles()) && $offer->user_id != user()->id) {
            abort(403, 'Unauthorized access');
        }

        $this->pageTitle = "Edit Offer Letter";
        $this->offer = $offer;

        return view('offer-letter.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $this->checkOfferLetterAccess();

        $offer = OfferLetter::findOrFail($id);

        if (!in_array('admin', user_roles()) && $offer->user_id != user()->id) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'gender'         => 'required|in:Male,Female,Other',
            'full_name'      => 'required|string|max:150',
            'email'          => 'required|email|unique:offer_letters,email,' . $offer->id,
            'designation'    => 'required|string|max:100',
            'salary'         => 'required|numeric|min:0',
            'joining_date'   => 'required|date',
            'employment_type'=> 'required',
        ]);

        $offer->update([
            'gender'         => $request->gender,
            'full_name'      => $request->full_name,
            'email'          => $request->email,
            'designation'    => $request->designation,
            'employment_type'=> $request->employment_type,
            'salary'         => $request->salary,
            'joining_date'   => $request->joining_date,
        ]);

        return redirect()
            ->route('letter.list')
            ->with('success', 'Offer Letter updated successfully!');
    }

    public function deleteLetter($id){
        try {
             $offer = OfferLetter::where('id', $id)->delete();
             return redirect()
                ->back()
                ->with('success', 'Offer Letter deleted successfully!');

        } catch (Exception ) {
            throw('Something went wrong please try again later!');
        }
    }


    // ── Helpers ───────────────────────────────────────────────────────────────
    private function getPrefix(string $gender): string
    {
        return match ($gender) {
            'Male'   => 'Mr.',
            'Female' => 'Mrs.',
            default  => '',
        };
    }

    private function imgBase64(string $path): string
    {
        if (!file_exists($path)) return '';
        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = $ext === 'png' ? 'image/png' : 'image/jpeg';
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    }

    private function numberToWords(int $n): string
    {
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven',
                 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen',
                 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty',
                 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        $below1k = function (int $num) use ($ones, $tens, &$below1k): string {
            if ($num === 0) return '';
            if ($num < 20)  return $ones[$num];
            if ($num < 100) return $tens[(int)($num / 10)] . ($num % 10 ? ' ' . $ones[$num % 10] : '');
            return $ones[(int)($num / 100)] . ' Hundred' . ($num % 100 ? ' ' . $below1k($num % 100) : '');
        };

        if ($n === 0) return 'Zero';
        $parts = [];
        if ($n >= 10000000) { $parts[] = $below1k((int)($n / 10000000)) . ' Crore';    $n %= 10000000; }
        if ($n >= 100000)   { $parts[] = $below1k((int)($n / 100000))   . ' Lakh';     $n %= 100000; }
        if ($n >= 1000)     { $parts[] = $below1k((int)($n / 1000))     . ' Thousand'; $n %= 1000; }
        if ($n > 0)         { $parts[] = $below1k($n); }
        return implode(' ', $parts);
    }
}