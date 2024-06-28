<?php

namespace App\Livewire\Customer;

use App\Livewire\Item\Sell;
use App\Livewire\Payment\RegisterPayment;
use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Search extends Component
{

    #[Validate('required', as:'# documento')]
    public $document='25588722';

    public ?Customer $customer=null;

    public function search()
    {
        $this->validate([
            'document' => 'required'
        ]);

        $this->customer = Customer::where('document', $this->document)->first();

        if ($this->customer) {
        $this->dispatch('customer-selected', customer: $this->customer);
        } else {
            $this->customer = null;
        }
    }

    #[On('payment-registered')]
    #[On('payment-credit-registered')]
    public function render()
    {
        $data=[
            'customers'=>$this->customer,
        ];
        return view('livewire.customer.search', $data);
    }
}
