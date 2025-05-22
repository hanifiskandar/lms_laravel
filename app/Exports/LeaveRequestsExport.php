<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveRequestsExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    protected $request;
    protected $row = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return LeaveRequest::with('user', 'leaveType')
            ->when($this->request->filled('leave_type'), function ($query) {
                $query->where('leave_type_id', $this->request->input('leave_type'));
            })
            ->when($this->request->filled('duration'), function ($query) {
                $query->where('duration', $this->request->input('duration'));
            })
            ->when($this->request->filled('start_date'), function ($query) {
                $query->whereDate('start_date', '>=', $this->request->input('start_date'));
            })
            ->when($this->request->filled('end_date'), function ($query) {
                $query->whereDate('end_date', '<=', $this->request->input('end_date'));
            })
            ->orderBy('id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',           // Like $loop->iteration
            'Name',
            'Leave Type',
            'Duration',
            'Start Date',
            'End Date',
            'Reason',
            'Status',
        ];
    }

    public function map($leaveReq): array
    {
        $this->row++;

        return [
            $this->row,
            $leaveReq->user->name ?? '-',
            $leaveReq->leaveType->name ?? '-',
            $leaveReq->duration,
            $leaveReq->start_date,
            $leaveReq->end_date,
            $leaveReq->reason,
            $leaveReq->status_label,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold to header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        // Add borders
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
