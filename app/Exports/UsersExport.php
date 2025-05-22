<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return User::query()
            ->with(['designation', 'department'])
            ->when($this->request->filled('designation'), function ($query) {
                $query->where('designation_id', $this->request->input('designation'));
            })
            ->when($this->request->filled('department'), function ($query) {
                $query->where('department_id', $this->request->input('department'));
            })
            ->orderBy('id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No', // corresponds to $loop->iteration in Blade
            'Name',
            'Email',
            'NRIC',
            'Designation',
            'Department',
            'Mobile Phone',
            'Office Phone',
            'Marital Status',
            'Start Date',
            'End Date',
        ];
    }

    public function map($user): array
    {
        static $row = 0;
        $row++;

        return [
            $row,
            $user->name,
            $user->email,
            $user->nric,
            $user->designation->name ?? '-',
            $user->department->name ?? '-',
            $user->mobile_phone,
            $user->office_phone,
            $user->martial_status,
            $user->start_date,
            $user->end_date,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold to heading row
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        // Apply border to all cells
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
