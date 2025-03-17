<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductosExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        return DB::table('productos as p')
            ->join('laboratorios as l', 'p.id_lab', '=', 'l.id')
            ->join('tipos_productos as tp', 'p.id_tip_prod', '=', 'tp.id')
            ->join('presentaciones as pr', 'p.id_present', '=', 'pr.id')
            ->leftJoin('lote as lo', function ($join) {
                $join->on('p.id', '=', 'lo.id_producto')
                    ->where('lo.estado', '=', 'Activo');
            })
            ->select(
                DB::raw('ROW_NUMBER() OVER(ORDER BY p.id) as N'),
                'p.nombre', 'p.concentracion', 'p.adicional', 'l.nombre as laboratorio',
                'pr.nombre as presentacion', 'tp.nombre as tipo',
                DB::raw('COALESCE(SUM(lo.cantidad_lote), 0) as stock'),
                'p.precio'
            )
            ->groupBy(
                'p.id', 'p.nombre', 'p.concentracion', 'p.adicional', 'l.nombre',
                'pr.nombre', 'tp.nombre', 'p.precio'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'N', 'Producto', 'Concentración', 'Adicional', 'Laboratorio',
            'Presentación', 'Tipo', 'Stock', 'Precio'
        ];
    }

    public function title(): string
    {
        return 'Reporte de Productos';
    }

    public function startCell(): string
    {
        return 'A3'; // Empieza en A3 para dejar espacio para el título
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Agregar el título principal
                $sheet->setCellValue('A1', 'Reporte General de Productos');
                $sheet->mergeCells('A1:I1'); // Unir celdas para el título
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['argb' => Color::COLOR_BLACK]
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // Estilos para los encabezados
                $sheet->getStyle('A3:I3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE]
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '2D9F39']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => Color::COLOR_BLACK]
                        ]
                    ]
                ]);

                // Resaltar productos sin stock (en rojo) y con poco stock (<10, en naranja)
                $highestRow = $sheet->getHighestRow();
                for ($row = 4; $row <= $highestRow; $row++) {
                    $stockCell = 'H' . $row;
                    $stockValue = $sheet->getCell($stockCell)->getValue();

                    if ($stockValue === '' || $stockValue == 0) {
                        // Productos sin stock en rojo
                        $sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                            'font' => ['color' => ['argb' => Color::COLOR_RED]]
                        ]);
                    } elseif ($stockValue > 0 && $stockValue < 10) {
                        // Productos con poco stock en naranja
                        $sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                            'font' => ['color' => ['argb' => 'FFA500']]
                        ]);
                    }
                }
            }
        ];
    }
}

