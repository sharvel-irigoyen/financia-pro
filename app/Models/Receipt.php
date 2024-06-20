<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function receiptDetails()
    {
        return $this->hasMany(ReceiptDetail::class);
    }

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
