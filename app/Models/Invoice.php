<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use SoftDeletes;
    protected $table = 'invoices';
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'value_status',
        'note',
        'payment_date',
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
