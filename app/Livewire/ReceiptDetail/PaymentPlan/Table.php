<?php

namespace App\Livewire\ReceiptDetail\PaymentPlan;

use App\Models\PaymentDetail;
use App\Models\PaymentPlan;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $receiptDetail;

    public function render()
    {
        $data=[
            'paymentPlans'=>$this->receiptDetail->paymentPlans()->paginate(12),
        ];
        return view('livewire.receipt-detail.payment-plan.table', $data);
    }
}
