<?php

namespace App\Livewire\Payment;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterPayment extends Component
{
    public ?Customer $customer = null;

    public $receipts=[];

    #[On('customer-selected')]
    public function handleCustomerSelected(Customer $customer)
    {
        $this->customer = $customer;
        $this->receipts = $customer->receipts->pluck('id', 'id')->toArray();
        // dd($this->receipts);
    }
    public function render()
    {
        return view('livewire.payment.register-payment');
    }
}
