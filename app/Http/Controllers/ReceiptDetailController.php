<?php

namespace App\Http\Controllers;

use App\Models\ReceiptDetail;
use Illuminate\Http\Request;

class ReceiptDetailController extends Controller
{

    public function index($id)
    {
        $detail = ReceiptDetail::where('receipt_id', $id)->first();
        return view('receipt-details', compact('detail'));
    }
}
