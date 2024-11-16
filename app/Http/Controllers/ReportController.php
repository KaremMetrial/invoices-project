<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
    public function report(Request $request)
    {
        $rdio = $request->rdio;

        if ($rdio == '1') {
            if ($request->type && empty($request->start_at) && empty($request->end_at)) {

                $invoices = Invoice::where('status', $request->type)->get();
                $type = $request->type;

                return view('reports.index', compact('type'))
                    ->withDetails($invoices);
            }

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $type = $request->type;

            $invoices = Invoice::whereBetween('invoice_date', [$start_at, $end_at])
                ->where('status', $request->type)
                ->get();

            return view('reports.index', compact('type', 'start_at', 'end_at'))
                ->withDetails($invoices);
        }

        if ($rdio == '2') {

            $invoices = Invoice::where('invoice_number', $request->invoice_number)->get();

            return view('reports.index')
                ->withDetails($invoices);
        }



    }
}
