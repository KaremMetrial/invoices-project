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

        return view("dashboard", compact("allInvoice", 'totalInvoice', 'chart'));
    }
    public static function getCharts()
    {
        $allInvoice = Invoice::count();

        $countInvoiceUnpaid = (Invoice::where('status', 'غير مدفوعة')->count() / $allInvoice) * 100;
        $countInvoicePaid = (Invoice::where('status', 'مدفوعة')->count() / $allInvoice) * 100;
        $countInvoicePartial = (Invoice::where('status', 'مدفوعة جزئيا')->count() / $allInvoice) * 100;

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
}
