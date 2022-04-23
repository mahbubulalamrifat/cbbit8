<?php

namespace App\Exports\ivca;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use DB;


class singleRetailer implements FromView, ShouldAutoSize, WithEvents, WithStyles, WithDrawings
{
    public $data;
    public $data2;


    public function __construct($singleAuditReport, $templateData){
        $this->data = $singleAuditReport;
        $this->data2 = $templateData;
    }


    public function view(): View
    {
        $singleAuditReport = (object) $this->data;
        $templateData = (object) $this->data2;
        //dd($singleAuditReport ,$templateData);
        
        return view('ivca.admin.excel.singleRetailer', compact('singleAuditReport','templateData'));
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('CPB Logo');
        $drawing->setPath(public_path('/all-assets/common/logo/cpb/cpbgroup.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('A2');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo2');
        $drawing2->setDescription('Food Logo');
        $drawing2->setPath(public_path('/all-assets/common/logo/cpb/food.png'));
        $drawing2->setHeight(60);
        $drawing2->setCoordinates('D2');
        $drawing2->setOffsetX(225);

        return [$drawing, $drawing2];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A8:D8')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A8:D8')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A46:D46')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A46:D46')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B:D')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B:D')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A15')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A21')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A27')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A33')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A38')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A39')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A40')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                 $event->sheet->getDelegate()->getStyle('A53')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
               
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        
       $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyle('A8:D40')->applyFromArray($styleArray);

        $sheet->getStyle('A45:D53')->applyFromArray($styleArray);

        $wholeArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyle('A1:D53')->applyFromArray($wholeArray);
    }



}