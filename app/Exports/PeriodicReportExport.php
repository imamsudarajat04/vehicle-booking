<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class PeriodicReportExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Vehicle ID',
            'Employee ID',
            'Start Time',
            'End Time',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->vehicle_id,
            $booking->employee_id,
            $booking->usage_start,
            $booking->usage_end,
            $booking->status,
            $booking->created_at,
            $booking->updated_at,
        ];
    }
}
