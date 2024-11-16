<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // get all invoices
        $invoices = Invoice::with(['section', 'product'])
            ->latest()
            ->get();

        return view('invoices.index', compact('invoices'));
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::with(['section', 'product'])->findOrFail($id);

        return view('invoices.print', compact('invoice'));
    }

    public function restoreInvoiceArchive($id)
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();

        return redirect()->back()->with('Add', 'تم استرجاع الفاتورة بنجاح');
    }
    public function getInvoicePaid()
    {
        $invoices = Invoice::with(['section', 'product'])->where('value_status', 1)->get();
        return view('invoices.paid', compact('invoices'));

    }

    public function getInvoiceUnpaid()
    {
        $invoices = Invoice::with(['section', 'product'])->where('value_status', 2)->get();
        return view('invoices.unpaid', compact('invoices'));

    }

    public function storeInvoiceArchive($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->back()->with('Add', 'تم ارشفة الفاتورة بنجاح ');
    }

    public function getInvoicePartial()
    {
        $invoices = Invoice::with(['section', 'product'])->where('value_status', 3)->get();
        return view('invoices.partial', compact('invoices'));
    }
    public function getInvoiceStatus($di)
    {

        $invoice = Invoice::findOrFail($di);
        return view('invoices.status', compact('invoice'));

    }

    public function updateInvoiceStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $status_text = $request->status == 1 ? 'مدفوعة' : ($request->status == 2 ? 'غير مدفوعة' : 'مدفوعة جزئيا');

        $invoice->update([
            'value_status' => $request->status,
            'payment_date' => $request->Payment_Date,
            'status' => $status_text,
        ]);

        InvoiceDetail::create([
            'invoice_id' => $id,
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product->id,
            'section' => $invoice->section->id,
            'value_status' => $request->status,
            'status' => $status_text,
            'payment_date' => $request->Payment_Date,
            'note' => $invoice->note,
            'user' => Auth::user()->name,
        ]);

        return redirect()->route('invoices.index')
            ->with('Add', 'تم تحديث حالة دفع الفاتورة بنجاح');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all sections
        $sections = Section::all();

        return view('invoices.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request): \Illuminate\Http\RedirectResponse
    {
        // store invoice
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product_id' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        //get last invoice number
        $invoice_id = Invoice::latest()->first()->id;
        InvoiceDetail::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new InvoiceAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        User::first()->notify(new AddInvoice($invoice_id));

        // redirect to invoices
        return redirect()->back()
            ->with('Add', 'تم اضافة الفاتورة بنجاح');
    }
    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
    /**
     * Display the specified resource.
    //  */
    public function show(Invoice $invoice)
    {
        // get invoice with details , attachments , section , product
        $invoice->load([
            'section',
            'product',
            'invoiceDetails',
            'invoiceAttachments',
        ]);

        return view('invoices.details', compact('invoice'));
    }
    /**
     *
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $sections = Section::select('id', 'section_name')->get();
        return view('invoices.edit', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {

        $invoice->update(
            [
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product_id' => $request->product,
                'section_id' => $request->Section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'note' => $request->note,
            ]
        );

        return redirect()->back()->with('Add', 'تم تعديل الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {

        // Force delete the invoice
        $invoice->forceDelete();

        // Delete attachments directory if it exists
        if (!empty($invoice->invoiceAttachments)) {
            File::deleteDirectory(public_path('Attachments/' . $invoice->invoice_number));
            $invoice->invoiceAttachments()->delete();
        }

        return redirect()->back()->with('Add', 'تم حذف الفاتورة بنجاح');
    }

    public function getInvoiceArchive()
    {
        $invoices = Invoice::with('section', 'product', 'invoiceDetails', 'invoiceAttachments')->onlyTrashed()->get();
        return view('invoices.archive', compact('invoices'));
    }

    public function getProducts($sectionId)
    {
        // Retrieve the products for the given section ID
        $products = Product::where('section_id', $sectionId)->pluck('product_name', 'id');
        // Return the products as JSON
        return response()->json($products);
    }
    public function showAttachments($invoiceNumber, $fileName)
    {
        $filePath = public_path('Attachments/' . $invoiceNumber . '/' . $fileName);
        // dd($filePath);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }

        abort(404, 'File not found');

    }
    public function downloadAttachments($invoiceNumber, $fileName)
    {
        $filePath = public_path('Attachments/' . $invoiceNumber . '/' . $fileName);
        // dd($filePath);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found');

    }

    public function deleteAttachments($invoiceNumber, $fileName)
    {
        $filePath = public_path('Attachments/' . $invoiceNumber . '/' . $fileName);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        InvoiceAttachment::where('invoice_number', $invoiceNumber)
            ->where('file_name', $fileName)
            ->delete();

        return redirect()->back()->with('Add', 'تم حذف المرفق بنجاح');
    }

    public function storeAttachment(Request $request)
    {
        $request->validate(
            [
                'file_name' => 'required|mimes:pdf,jpeg,png,jpg,gif',
            ],
            [
                'file_name.required' => 'يرجى ارفاق المرفق',
                'file_name.mimes' => 'يرجى ارفاق المرفق بصيغة صالحة',
            ]
        );
        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
        $attachments = new InvoiceAttachment();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->created_by = Auth::user()->name;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);

        return redirect()->back()->with('Add', 'تم اضافة المرفق بنجاح');
    }
}
