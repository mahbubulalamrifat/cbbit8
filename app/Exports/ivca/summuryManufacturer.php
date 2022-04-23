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


class summuryManufacturer implements FromView, ShouldAutoSize, WithEvents, WithStyles, WithDrawings
{
    public $data;


    public function __construct($finalResult){
        $this->data = $finalResult;
    }


    public function view(): View
    {
        $finalResult = (object) $this->data;
        //dd($finalResult);
        
        return view('ivca.admin.excel.summuryManufacturer', compact('finalResult'));
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('CPB Logo');
        $drawing->setPath(public_path('/all-assets/common/logo/cpb/cpbgroup.png'));
        $drawing->setHeight(40);
        $drawing->setCoordinates('A1');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo2');
        $drawing2->setDescription('Food Logo');
        $drawing2->setPath(public_path('/all-assets/common/logo/cpb/food.png'));
        $drawing2->setHeight(40);
        $drawing2->setCoordinates('D1');
        $drawing2->setOffsetX(35);

        return [$drawing, $drawing2];

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A19:D19')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A19:D19')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B:D')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B:D')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A9:D9')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A9:D9')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A26')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A27')
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

        

        $sheet->getStyle('A19:D27')->applyFromArray($styleArray);


    }

    


}