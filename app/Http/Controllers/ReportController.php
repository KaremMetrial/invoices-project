<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
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

    public function usersReport(Request $request)
    {

        $sections = Section::all();
        return view('reports.users', compact('sections'));
    }

    public function getUsersReport(Request $request)
    {
        // dd($request->all());

        if ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {

            $invoices = Invoice::select('*')->where('section_id', '=', $request->section)->where('product_id', '=', $request->product)->get();
            $sections = Section::all();
            return view('reports.users', compact('sections'))->withDetails($invoices);

        } else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', '=', $request->Section)->where('product_id', '=', $request->product)->get();
            $sections = Section::all();
            return view('reports.users', compact('sections'))->withDetails($invoices);

        }
    }
}
