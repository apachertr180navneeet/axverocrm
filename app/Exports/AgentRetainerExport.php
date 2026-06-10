<?php

namespace App\Exports;

use App\Models\AgentRetainer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AgentRetainerExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = AgentRetainer::query();

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('gender')) {
            $query->where('gender', $this->request->gender);
        }

        if ($this->request->filled('from_date') && $this->request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $this->request->from_date . ' 00:00:00',
                $this->request->to_date . ' 23:59:59'
            ]);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Mobile',
            'Address',
            'Gender',
            'Date of Birth',
            'Marital Status',
            'Person Name',
            'Person Mobile',
            'Created At',
        ];
    }

    public function map($retainer): array
    {
        return [
            $retainer->id,
            $retainer->name,
            $retainer->mobile,
            $retainer->address ?? '--',
            $retainer->gender ?? '--',
            $retainer->date_of_birth ?? '--',
            $retainer->marital_status ?? '--',
            $retainer->person_name ?? '--',
            $retainer->person_mobile ?? '--',
            $retainer->created_at ? $retainer->created_at->format('d-m-Y h:i A') : '--',
        ];
    }
}
