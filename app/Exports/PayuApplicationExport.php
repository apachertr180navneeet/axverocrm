<?php

namespace App\Exports;

use App\Models\HiringSubmission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayuApplicationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $search = $this->request->input('search');
        $fromDate = $this->request->input('from_date');
        $toDate = $this->request->input('to_date');
        $paymentStatus = $this->request->input('payment_status');

        $query = HiringSubmission::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('txnid', 'LIKE', "%{$search}%");
            });
        }

        if ($fromDate) {
            $query->whereDate('submitted_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('submitted_at', '<=', $toDate);
        }

        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'ID',
            'Name',
            'Mobile',
            'Email',
            'Joining Date',
            'Designation',
            'Department',
            'Senior Manager',
            'Senior Manager Mobile',
            'Amount',
            'Payment Status',
            'Transaction ID',
            'Submitted Date'
        ];
    }

    public function map($row): array
    {
        static $sno = 0;
        $sno++;

        return [
            $sno,
            $row->id,
            $row->name,
            $row->mobile,
            $row->email,
            $row->joining_date ? date('d-m-Y', strtotime($row->joining_date)) : '-',
            $row->designation,
            $row->department,
            $row->senior_manager_name,
            $row->senior_manager_mobile,
            $row->amount,
            strtoupper($row->payment_status),
            $row->txnid,
            $row->created_at ? date('d-m-Y H:i:s', strtotime($row->created_at)) : '-'
        ];
    }
}
