<?php

namespace App\Exports;

use App\Models\ExecutiveRetainerApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExecutiveRetainerExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ExecutiveRetainerApplication::orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Mobile',
            'Email',
            'Post',
            'Date of Joining',
            'Amount',
            'Payment Status',
            'Transaction ID',
            'Paid At',
            'Created At',
        ];
    }

    public function map($application): array
    {
        return [
            $application->id,
            $application->name,
            $application->mobile,
            $application->email,
            $application->post,
            $application->date_of_joining ? $application->date_of_joining->format('d-m-Y') : '--',
            $application->amount,
            $application->payment_status,
            $application->txnid ?? '--',
            $application->paid_at ? $application->paid_at->format('d-m-Y h:i A') : '--',
            $application->created_at ? $application->created_at->format('d-m-Y h:i A') : '--',
        ];
    }
}
