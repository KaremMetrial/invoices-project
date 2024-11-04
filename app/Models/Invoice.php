<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $table = 'invoices';
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product_id',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date',
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class);
    }
    public function invoiceAttachments(){
        return $this->hasMany(InvoiceAttachment::class);
    }

}
