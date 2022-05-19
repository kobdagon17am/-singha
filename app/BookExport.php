<?php

namespace App;

// use App\User;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Bookexport implements  FromView, ShouldAutoSize
{
    public function __construct($view, $data = "")
        {
            $this->view = $view;
            $this->data = $data;
        }

    public function view(): View
        {
            // $this->drawings();
            return view(
                $this->view,
                $this->data
            );
        }
        
    // public function styles(Worksheet $sheet)
    // {
    //     $arr = [];

    //     for ($i = 1; $i <= $this->data['booth'] + 2; $i++) {
    //         $arr['A'.$i] = ['alignment' => ['vertical' => 'center']];
    //         $arr['B'.$i] = ['alignment' => ['vertical' => 'center']];
    //         $sheet->getStyle("C{$i}:AG{$i}")->getAlignment()->setVertical('top');
    //     }

    //     return $arr;
    // }
}
