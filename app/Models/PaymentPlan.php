<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function receiptDetail()
    {
        return $this->belongsTo(ReceiptDetail::class);
    }
}
