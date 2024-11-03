<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'product',
        'section',
        'status',
        'value_status',
        'note',
        'user',
        'Payment_Date',
    ];
}
