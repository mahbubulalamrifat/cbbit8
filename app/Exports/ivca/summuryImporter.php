<?php

namespace App\Exports\ivca;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class summuryImporter implements FromView, ShouldAutoSize, WithEvents, WithStyles, WithDrawings
{
    public $data;


    public function __construct($finalResult){
        $this->data = $finalResult;
    }


    public function view(): View
    {
        $finalResult = (object) $this->data;
        //dd($finalResult);
        
        return view('ivca.admin.excel.summuryImporter', compact('finalResult'));
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
        $drawing2->setOffsetX(32);

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

                // foreach ($event->sheet->getColumnIterator('A') as $row) {
                //     foreach ($row->getCellIterator() as $cell) {
                //         if (str_contains($cell->getValue(), '://')) {
                //             $cell->setHyperlink(new Hyperlink($cell->getValue(), 'Read'));

                //             // Upd: Link styling added
                //             $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                //                 'font' => [
                //                     'color' => ['rgb' => '0000FF'],
                //                     'underline' => 'single'
                //                 ]
                //             ]);
                //         }
                //     }
                // }
               
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

        

        $sheet->getStyle('A19:D26')->applyFromArray($styleArray);


    }



}
