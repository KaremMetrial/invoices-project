<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class HomeController extends Controller
{
    public function index()
    {
        $totalInvoice = Invoice::sum('total');
        $allInvoice = Invoice::count();
        $chart = self::getCharts();
        $chart2 = self::getCharts2();
    
        return view("dashboard", compact("allInvoice", 'totalInvoice', 'chart', 'chart2'));
    }
    
    public static function getCharts()
    {
        $allInvoice = Invoice::count();
    
        $countInvoiceUnpaid = $allInvoice > 0 
            ? (Invoice::where('status', 'غير مدفوعة')->count() / $allInvoice) * 100 
            : 0;
        $countInvoicePaid = $allInvoice > 0 
            ? (Invoice::where('status', 'مدفوعة')->count() / $allInvoice) * 100 
            : 0;
        $countInvoicePartial = $allInvoice > 0 
            ? (Invoice::where('status', 'مدفوعة جزئيا')->count() / $allInvoice) * 100 
            : 0;
    
        $chart = Chartjs::build()
            ->name('الفواتير')
            ->type('bar')
            ->size([
                'width' => 400,
                'height' => 200,
            ])
            ->labels([
                'الفواتير الغير مدفوعة',
                'الفواتير المدفوعة',
                'الفواتير المدفوعة جزئيا',
            ])
            ->datasets([
                [
                    'label' => 'الفواتير الغير مدفوعة',
                    'backgroundColor' => '#fa4765',
                    'data' => [$countInvoiceUnpaid, 0, 0],
                ],
                [
                    'label' => 'الفواتير المدفوعة',
                    'backgroundColor' => '#0b9f6f',
                    'data' => [0, $countInvoicePaid, 0],
                ],
                [
                    'label' => 'الفواتير المدفوعة جزئيا',
                    'backgroundColor' => '#f57b3a',
                    'data' => [0, 0, $countInvoicePartial],
                ],
            ])
            ->options([
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ],
            ]);
    
        return $chart;
    }
    
    public static function getCharts2()
    {
        $allInvoice = Invoice::count();
    
        $countInvoiceUnpaid = $allInvoice > 0 
            ? (Invoice::where('status', 'غير مدفوعة')->count() / $allInvoice) * 100 
            : 0;
        $countInvoicePaid = $allInvoice > 0 
            ? (Invoice::where('status', 'مدفوعة')->count() / $allInvoice) * 100 
            : 0;
        $countInvoicePartial = $allInvoice > 0 
            ? (Invoice::where('status', 'مدفوعة جزئيا')->count() / $allInvoice) * 100 
            : 0;
    
        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$countInvoiceUnpaid, $countInvoicePaid, $countInvoicePartial],
                ],
            ])
            ->options([]);
    
        return $chartjs_2;
    }
        
}
