<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function creditAccount()
    {
        return $this->hasOne(CreditAccount::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->lastname;
    }
}
