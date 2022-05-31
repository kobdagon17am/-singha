<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class reportCheckIn implements FromView,ShouldAutoSize
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        // dd($this->data);
        return view('backend.report.report_audit_checkInsale_xlsx', [
            'data' => $this->data
        ]);
    }
   
    
}

