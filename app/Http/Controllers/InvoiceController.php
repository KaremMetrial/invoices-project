<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
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

        // redirect to invoices
        return redirect()->back()
            ->with('Add', 'تم اضافة الفاتورة بنجاح');
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

        $invoice->update($request->all());

        return redirect()->back()->with('Add', 'تم تعديل الفاتورة بنجاح');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // delete invoice
        $invoice->delete();

        return redirect()->back()->with('Add', 'تم حذف الفاتورة بنجاح');
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
