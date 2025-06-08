<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{
    Alignment,
    Color,
    Fill,
    Borders,
    Border,
}; 
use PhpOffice\PhpSpreadsheet\Chart\{
    Chart,
    DataSeries,
    DataSeriesValues,
    Legend,
    PlotArea,
    Title,
};
use Illuminate\Support\Facades\{
    Hash,
    Validator, 
    Auth, 
    DB, 
};
use App\Models\{
    Encounter,
    ExpenseRecord,
    MedicalUnit,
    ItemCategory,
}; 

class ReportController extends Controller
{ 
    public function generateReport(Request $request){
        $startDate = Carbon::parse($request->input("start"));  
        $endDate = Carbon::parse($request->input("end")." 23:59:00");
        
        $encounters = Encounter::select([
                                    "encounters.id",
                                    "encounters.items",
                                    "encounters.payment_method",
                                    "encounters.date",
                                    "encounters.subject",
                                    "encounters.subtotal",
                                    "medical_units.name", 
                                ])
                                ->whereBetween('encounters.date', [$startDate, $endDate])
                                ->where('encounters.status', "2")
                                ->leftJoin('medical_units', 'encounters.medical_unit_id', '=', 'medical_units.id')
                                ->orderBy('encounters.date', 'desc');

        $expensesRecords = ExpenseRecord::select([
                                    "expenses_records.id",
                                    "expenses_records.items", 
                                    "expenses_records.date",
                                    "expenses_records.payment_method",
                                    "medical_units.name", 
                                ])
                                ->whereBetween('date', [$startDate, $endDate])
                                ->leftJoin('medical_units', 'expenses_records.medical_unit_id', '=', 'medical_units.id')
                                ->orderBy('expenses_records.date', 'desc');

        if($request->input("medical_unit")){
            $medical_unit = $request->input("medical_unit");

            $encounters->where(function ($query) use ($medical_unit) {
                $query->where("medical_unit_id", $medical_unit);
            });

            $expensesRecords->where(function ($query) use ($medical_unit) {
                $query->where("medical_unit_id", $medical_unit);
            });
        }

        $encounters = $encounters->get();
        $expensesRecords = $expensesRecords->get();

        $allItems = [
            'services' => [],
            'supplies' => []
        ];
        $servicesType = [
            'encounters' => [
                "total" => 0,
                "name" => __("routes.encounters"),
                "qty" => 0,
            ]
        ];
        $itemsPerDay = [];
        $expensesPerDay = [];
        $totalIncome = 0;
        $totalExpenses = 0;

        $allPayments = [
            1  => ["name" => __('payment_methods.credit_cards'), "total" => 0],
            2  => ["name" => __('payment_methods.debit_cards'), "total" => 0],
            3  => ["name" => __('payment_methods.cash_payments'), "total" => 0],
            4  => ["name" => __('payment_methods.bank_transfers'), "total" => 0],
            5  => ["name" => __('payment_methods.checks'), "total" => 0],
        ];

        foreach ($encounters as $encounter) {
            $items = json_decode($encounter->items);
            $total = 0;

            if(!isset($itemsPerDay[$encounter->date])){
                $itemsPerDay[$encounter->date] = [];
            }

            if(!isset($itemsPerDay[$encounter->date][$encounter->payment_method])){
                $itemsPerDay[$encounter->date][$encounter->payment_method] = [
                    [
                        $encounter->subtotal =>[
                            "name" => __("subjects.".$encounter->subject),
                            "qty" => 1,
                            "barcode" => "",
                            "cat" => __("routes.encounters"),
                        ]  
                    ]
                ];
            }

            foreach ($items as $key => $item) {
                if($item->type == "service"){
                    if(!isset($allItems['services'][$item->id])){
                        $allItems['services'][$item->id]['qty'] = 0;
                        $allItems['services'][$item->id]['name'] = "";
                    }

                    $allItems['services'][$item->id]['qty']+= intval($item->qty);
                    $allItems['services'][$item->id]['name'] = $item->name;

                    if(!isset($servicesType[$item->cat_id])){
                        $cat = ItemCategory::find($item->cat_id);
    
                        $servicesType[$item->cat_id] = [
                            "total" => 0,
                            "name" => __("item_categories.".$cat->name),
                            "qty" => 0,
                        ];
                    }
    
                    $servicesType[$item->cat_id]['total'] += (floatval($item->qty)*floatval($item->price));
                    $servicesType[$item->cat_id]['qty'] += floatval($item->qty);
                }else{ 
                    if(!isset($allItems['supplies'][$item->id])){
                        $allItems['supplies'][$item->id]['qty'] = 0;
                        $allItems['supplies'][$item->id]['name'] = "";
                    }

                    $allItems['supplies'][$item->id]['qty']+= intval($item->qty);
                    $allItems['supplies'][$item->id]['name'] = $item->name;
                }

                if(!isset($itemsPerDay[$encounter->date][$encounter->payment_method][$item->id])){
                    $itemsPerDay[$encounter->date][$encounter->payment_method][$item->id] = [];
                }

                if(!isset($itemsPerDay[$encounter->date][$encounter->payment_method][$item->id][$item->price])){
                    $cat = ItemCategory::find($item->cat_id);
                    $itemsPerDay[$encounter->date][$encounter->payment_method][$item->id][$item->price] = [
                        "name" => $item->name,
                        "qty" => 0,
                        "barcode" => $item->barcode,
                        "cat" => __("item_categories.".$cat->name),
                    ];
                }

                $itemsPerDay[$encounter->date][$encounter->payment_method][$item->id][$item->price]['qty']+= intval($item->qty);

                $total+= (floatval($item->qty)*floatval($item->price));
            }

            $allPayments[$encounter->payment_method]['total']+= $total;
            $totalIncome+= $total+floatval($encounter->subtotal);;
            $servicesType['encounters']['total'] += floatval($encounter->subtotal);
            $servicesType['encounters']['qty']++;
        }

        foreach ($expensesRecords as $expensesRecord) {
            $items = json_decode($expensesRecord->items);
            $total = 0;

            if(!isset($expensesPerDay[$expensesRecord->date])){
                $expensesPerDay[$expensesRecord->date] = [];
            }

            if(!isset($expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method])){
                $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method] = [];
            }

            foreach ($items as $key => $item) { 

                if(!isset($expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id])){
                    $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id] = [];
                }

                if(!isset($expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id][$item->price])){
                    $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id][$item->price] = [
                        "name" => $item->name,
                        "qty" => 0,
                        "barcode" => $item->barcode, 
                        "cat" => __("routes.expenses"),
                    ];
                }

                $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id][$item->price]['qty']+= intval($item->qty);

                $totalExpenses+= (floatval($item->qty)*floatval($item->price));
            } 
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Estilo para la cabecera
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FF0000']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        $regularStyle = [ 
            'font' => [ 
                'color' => ['rgb' => '333333']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EAEAEA']
            ],
        ];

        // Estilo para las celdas con fondo rojo claro
        $cellStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FF0000']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFEEEE']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        // Combinar celdas para la cabecera principal
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'Control de caja');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Segunda fila en blanco
        $sheet->mergeCells('A2:H2');

        // Tercera fila con títulos
        $sheet->setCellValue('B3', 'Tipo de servicio');
        $sheet->setCellValue('C3', 'Cantidad');
        $sheet->setCellValue('D3', 'Totales');
        $sheet->setCellValue('F3', 'Tipo de caja');
        $sheet->setCellValue('G3', 'Nombre');
        $sheet->setCellValue('H3', 'Saldo');

        // Aplicar estilo a las celdas con fondo rojo claro
        $sheet->getStyle('B3:D3')->applyFromArray($cellStyle);
        $sheet->getStyle('F3:H3')->applyFromArray($cellStyle);

        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $indexServiceType = 4;

        foreach ($servicesType as $key => $service) {
            $sheet->setCellValue('B'.($indexServiceType), $service['name']);
            $sheet->setCellValue('C'.($indexServiceType), $service['qty']);
            $sheet->setCellValue('D'.($indexServiceType), $service['total']);

            $indexServiceType++;
        }

        $sheet->getStyle('B4:D'.($indexServiceType))->applyFromArray($regularStyle);
 
        $sheet->setCellValue('C'.($indexServiceType), "Saldo Total de caja");
        $sheet->setCellValue('D'.($indexServiceType), array_reduce(array_values($servicesType), function($accumulator, $currentValue) {
            return $accumulator + $currentValue['total'];
        }, 0)); 

        $sheet->getStyle('C'.($indexServiceType))->applyFromArray($cellStyle);

        $indexPayment = 3;

        $labels = [];
        $values = [];

        foreach ($allPayments as $key => $payment) { 
            $indexPayment++;
            
            $sheet->setCellValue('F'.($indexPayment), $key);
            $sheet->setCellValue('G'.($indexPayment), $payment['name']);
            $sheet->setCellValue('H'.($indexPayment), $payment['total']); 

            $labels[] = $payment['name'];  
            $values[] = $payment['total'];
        }
        
        $sheet->getStyle('F4:H'.($indexPayment))->applyFromArray($regularStyle);

        $currentIndex = ($indexServiceType >= $indexPayment ? $indexServiceType : $indexPayment)+2;
        $startIndex = $currentIndex+1;

        $sheet->setCellValue('B'.$currentIndex, 'Fecha');
        $sheet->setCellValue('C'.$currentIndex, 'Codigo');
        $sheet->setCellValue('D'.$currentIndex, 'Categoria');
        $sheet->setCellValue('E'.$currentIndex, 'Nombre comercial');
        $sheet->setCellValue('F'.$currentIndex, 'Tipo de caja');
        $sheet->setCellValue('G'.$currentIndex, 'Entradas');
        $sheet->setCellValue('H'.$currentIndex, 'Salidas');
        
        $sheet->getStyle('B'.$currentIndex.':H'.$currentIndex)->applyFromArray($cellStyle); 

        foreach ($itemsPerDay as $date => $rows) {
            foreach ($rows as $type => $items) { 
                foreach ($items as $item) { 
                    foreach ($item as $price => $details) { 
                        $currentIndex++;

                        $sheet->setCellValue('B'.$currentIndex, date("Y-m-d",strtotime($date)));
                        $sheet->setCellValue('G'.$currentIndex, $price*$details['qty']); 
                        $sheet->setCellValue('C'.$currentIndex, $details['barcode']);
                        $sheet->setCellValue('D'.$currentIndex, $details['cat']);
                        $sheet->setCellValue('E'.$currentIndex, $details['name']); 
                        $sheet->setCellValue('F'.$currentIndex, $type); 
                    }
                }
            }
        }

        foreach ($expensesPerDay as $date => $rows) {
            foreach ($rows as $type => $items) { 
                foreach ($items as $item) { 
                    foreach ($item as $price => $details) { 
                        $currentIndex++;

                        $sheet->setCellValue('B'.$currentIndex, date("Y-m-d",strtotime($date)));
                        $sheet->setCellValue('H'.$currentIndex, $price*$details['qty']); 
                        $sheet->setCellValue('C'.$currentIndex, $details['barcode']);
                        $sheet->setCellValue('D'.$currentIndex, $details['cat']);
                        $sheet->setCellValue('E'.$currentIndex, $details['name']); 
                        $sheet->setCellValue('F'.$currentIndex, $type); 
                    }
                }
            }
        }

        $currentIndex++;

        $sheet->setCellValue('F'.$currentIndex, "totales"); 
        $sheet->setCellValue('G'.$currentIndex, $totalIncome); 
        $sheet->setCellValue('H'.$currentIndex, $totalExpenses); 

        $sheet->getStyle('G'.$currentIndex.':H'.$currentIndex)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

        $sheet->setCellValue('G'.($currentIndex+2), "Balance"); 
        $sheet->setCellValue('H'.($currentIndex+2), ($totalIncome-$totalExpenses)); 
        
        $sheet->getStyle('G'.($currentIndex+2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 
        $sheet->getStyle('H'.($currentIndex+2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 
        $sheet->getStyle('G'.($currentIndex+2))->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('H'.($currentIndex+2))->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle('B'.($startIndex).':H'.($currentIndex-1))->applyFromArray($regularStyle);
        $sheet->getStyle('F'.($currentIndex).':H'.($currentIndex))->applyFromArray($regularStyle);

        $sheet->getStyle('G'.($currentIndex+2).':H'.($currentIndex+2))->applyFromArray($regularStyle);

        foreach (range(3, $currentIndex+2) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(20);  // Ajusta el valor según sea necesario
        }
        
         

        $writer = new Xlsx($spreadsheet);
        $fileName = 'control_de_caja.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$fileName}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function previewReport(Request $request){ 
        $validator = Validator::make(request()->all(), [
            'start' => 'required|before:end',
            'end' => 'required|after:start', 
        ],
        [
            'start.required' => __('rules.start_required'),
            'end.required' => __('rules.end_required'), 
            'start.before' => __('rules.start_before'),
            'end.after' => __('rules.end_after'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $startDate = Carbon::parse($request->input("start"));  
        $endDate = Carbon::parse($request->input("end")." 23:59:00");
        
        $encounters = Encounter::select([
                                    "encounters.id",
                                    "encounters.items",
                                    "encounters.payment_method",
                                    "encounters.date",
                                    "encounters.subject",
                                    "encounters.subtotal",
                                    "medical_units.name", 
                                ])
                                ->whereBetween('encounters.date', [$startDate, $endDate])
                                ->where('encounters.status', "2")
                                ->leftJoin('medical_units', 'encounters.medical_unit_id', '=', 'medical_units.id')
                                ->orderBy('encounters.date', 'desc');

        $expensesRecords = ExpenseRecord::select([
                                    "expenses_records.id",
                                    "expenses_records.items", 
                                    "expenses_records.date",
                                    "expenses_records.payment_method",
                                    "medical_units.name", 
                                ])
                                ->whereBetween('date', [$startDate, $endDate])
                                ->leftJoin('medical_units', 'expenses_records.medical_unit_id', '=', 'medical_units.id')
                                ->orderBy('expenses_records.date', 'desc');

        if($request->input("medical_unit")){
            $medical_unit = $request->input("medical_unit");

            $encounters->where(function ($query) use ($medical_unit) {
                $query->where("medical_unit_id", $medical_unit);
            });

            $expensesRecords->where(function ($query) use ($medical_unit) {
                $query->where("medical_unit_id", $medical_unit);
            });
        }

        $encounters = $encounters->get();
        $expensesRecords = $expensesRecords->get();

        $allItems = [
            'services' => [],
            'supplies' => []
        ];
        $servicesType = [
            'encounters' => [
                "total" => 0,
                "name" => __("routes.encounters"),
                "qty" => 0,
            ]
        ];
        $itemsPerDay = [];
        $expensesPerDay = [];
        $totalIncome = 0;
        $totalExpenses = 0;

        $allPayments = [
            1  => ["name" => __('payment_methods.credit_cards'), "total" => 0],
            2  => ["name" => __('payment_methods.debit_cards'), "total" => 0],
            3  => ["name" => __('payment_methods.cash_payments'), "total" => 0],
            4  => ["name" => __('payment_methods.bank_transfers'), "total" => 0],
            5  => ["name" => __('payment_methods.checks'), "total" => 0],
        ];

        foreach ($encounters as $encounter) {
            $items = json_decode($encounter->items);
            $total = 0;

            if(!isset($itemsPerDay[$encounter->date])){
                $itemsPerDay[$encounter->date] = [];
            }

            if(!isset($itemsPerDay[$encounter->date][$encounter->payment_method])){
                $itemsPerDay[$encounter->date][$encounter->payment_method] = [
                    [
                        $encounter->subtotal =>[
                            "name" => __("subjects.".$encounter->subject),
                            "qty" => 1,
                            "barcode" => "",
                            "cat" => __("routes.encounters"),
                        ]  
                    ]
                ];
            }

            foreach ($items as $key => $item) {
                if($item->type == "service"){
                    if(!isset($allItems['services'][$item->id])){
                        $allItems['services'][$item->id]['qty'] = 0;
                        $allItems['services'][$item->id]['name'] = "";
                    }

                    $allItems['services'][$item->id]['qty']+= intval($item->qty);
                    $allItems['services'][$item->id]['name'] = $item->name;

                    if(!isset($servicesType[$item->cat_id])){
                        $cat = ItemCategory::find($item->cat_id);
    
                        $servicesType[$item->cat_id] = [
                            "total" => 0,
                            "name" => __("item_categories.".$cat->name),
                            "qty" => 0,
                        ];
                    }
    
                    $servicesType[$item->cat_id]['total'] += (floatval($item->qty)*floatval($item->price));
                    $servicesType[$item->cat_id]['qty'] += floatval($item->qty);
                }else{ 
                    if(!isset($allItems['supplies'][$item->id])){
                        $allItems['supplies'][$item->id]['qty'] = 0;
                        $allItems['supplies'][$item->id]['name'] = "";
                    }

                    $allItems['supplies'][$item->id]['qty']+= intval($item->qty);
                    $allItems['supplies'][$item->id]['name'] = $item->name;
                }

                if(!isset($itemsPerDay[$encounter->date][$encounter->payment_method][$item->id])){
                    $itemsPerDay[$encounter->date][$encounter->payment_method][$item->id] = [];
                }

                if(!isset($itemsPerDay[$encounter->date][$encounter->payment_method][$item->id][$item->price])){
                    $cat = ItemCategory::find($item->cat_id);
                    $itemsPerDay[$encounter->date][$encounter->payment_method][$item->id][$item->price] = [
                        "name" => $item->name,
                        "qty" => 0,
                        "barcode" => $item->barcode,
                        "cat" => __("item_categories.".$cat->name),
                    ];
                }

                $itemsPerDay[$encounter->date][$encounter->payment_method][$item->id][$item->price]['qty']+= intval($item->qty);

                $total+= (floatval($item->qty)*floatval($item->price));
            }

            $allPayments[$encounter->payment_method]['total']+= $total;
            $totalIncome+= $total+floatval($encounter->subtotal);;
            $servicesType['encounters']['total'] += floatval($encounter->subtotal);
            $servicesType['encounters']['qty']++;
        }

        foreach ($expensesRecords as $expensesRecord) {
            $items = json_decode($expensesRecord->items);
            $total = 0;

            if(!isset($expensesPerDay[$expensesRecord->date])){
                $expensesPerDay[$expensesRecord->date] = [];
            }

            if(!isset($expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method])){
                $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method] = [];
            }

            foreach ($items as $key => $item) { 

                if(!isset($expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id])){
                    $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id] = [];
                }

                if(!isset($expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id][$item->price])){
                    $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id][$item->price] = [
                        "name" => $item->name,
                        "qty" => 0,
                        "barcode" => $item->barcode, 
                        "cat" => __("routes.expenses"),
                    ];
                }

                $expensesPerDay[$expensesRecord->date][$expensesRecord->payment_method][$item->id][$item->price]['qty']+= intval($item->qty);

                $totalExpenses+= (floatval($item->qty)*floatval($item->price));
            } 
        }

        return response()->json([
            "status" => 1, 
            "encounters" => $encounters,
            "expensesRecords" => $expensesRecords,
            "allItems" => $allItems,
            "allPayments" => $allPayments,
            "itemsPerDay" => $itemsPerDay,
            "expensesPerDay" => $expensesPerDay,
            "servicesType" => $servicesType,
            "totalIncome" => $totalIncome,
            "totalExpenses" => $totalExpenses,
        ]);
    }
}



