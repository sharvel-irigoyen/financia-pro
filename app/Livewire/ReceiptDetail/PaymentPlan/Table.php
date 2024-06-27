<?php

namespace App\Livewire\ReceiptDetail\PaymentPlan;

use App\Models\PaymentDetail;
use App\Models\PaymentPlan;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $receiptDetail;

    public function mount()
    {
        $this->dispatch('payment-plan-loaded', receiptDetail: $this->receiptDetail)->to(RegisterOverdue::class);
    }

    #[On('make-overdue')]
    public function render()
    {
        $data=[
            'paymentPlans'=>$this->receiptDetail?->paymentPlans()->paginate(12) ??  PaymentPlan::whereNull('id')->paginate(12),
            'graceType' => $this->receiptDetail?->grace_period_type,
        ];
        return view('livewire.receipt-detail.payment-plan.table', $data);
    }
}
