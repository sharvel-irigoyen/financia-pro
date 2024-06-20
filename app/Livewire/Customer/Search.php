<?php

namespace App\Livewire\Customer;

use App\Livewire\Item\Sell;
use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Search extends Component
{

    #[Validate('required', as:'# documento')]
    public $document='4731192061';

    public ?Customer $customer=null;

    public function search()
    {
        $this->validate([
            'document' => 'required'
        ]);

        $this->customer = Customer::where('document', $this->document)->first();

        if ($this->customer) {
            $this->dispatch('customer-selected', customer: $this->customer)->to(Sell::class);
        } else {
            $this->customer = null;
        }
    }



    public function render()
    {
        $data=[
            'customers'=>$this->customer,
        ];
        return view('livewire.customer.search', $data);
    }
}
