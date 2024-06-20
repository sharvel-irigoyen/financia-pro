<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function paymentPlans()
    {
        return $this->hasMany(PaymentPlan::class);
    }
}
