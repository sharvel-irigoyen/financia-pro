<?php

namespace App\Livewire\Payment;

use App\Models\Customer;
use App\Models\Receipt;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterPayment extends Component
{
    public ?Customer $customer = null;

    public $receipts=[];

    #[Validate('required', as: 'recibo')]
    public $receiptId='';

    public ?Receipt $receipt=null;

    public $paymentPlan;

    public $paymentPlans=[];

    #[On('customer-selected')]
    public function handleCustomerSelected(Customer $customer)
    {
        $this->customer = $customer;
        $this->receipts = $customer->receipts ->where('interest_total', '!=', 0)->pluck('id', 'id')->toArray();


        // dd($this->receipt);
        // dump($this->customer->receipts()->where('id', $this->receiptId)->first());
    }

    public function updatedReceiptId()
    {
        $this->receipt = $this->customer->receipts()->where('id', $this->receiptId)->first();
        $this->paymentPlan=$this->receipt->receiptDetails?->first()?->paymentPlans?->firstWhere('payment_date', '>=', now());
        $this->paymentPlans=$this->receipt->receiptDetails?->first()?->paymentPlans;

        $isOverdue = Carbon::parse($this->paymentPlan->payment_date)->isBefore(now());
        if ($isOverdue) {
            $this->paymentPlan->update([
                'is_overdue' => true,
            ]);
        }
    }

    public function makePayment()
    {
        $this->validate([
            'receiptId' => 'required',
        ]);

        if ($this->paymentPlan->status) {
            $this->addError('payment', 'Este pago ya fue realizado previamente.');
            return;
        }

        $allPaymentsCompleted = collect($this->paymentPlans)->where('status', false)->isEmpty();

        if ($allPaymentsCompleted) {
            $this->receipt->update(['status' => true]);
        }
        $this->paymentPlan->update([
            'status' => true,
        ]);

        $this->customer->creditAccount()->decrement('balance', $this->paymentPlan->installment);
        $this->dispatch('payment-registered');
    }

    #[On('payment-registered')]
    public function render()
    {
        return view('livewire.payment.register-payment');
    }
}
