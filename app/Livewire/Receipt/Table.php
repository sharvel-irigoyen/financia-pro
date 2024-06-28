<?php

namespace App\Livewire\Receipt;

use App\Models\Customer;
use App\Models\Receipt;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public ?Customer $customer = null;

    #[On('customer-selected')]
    public function handleCustomerSelected(Customer $customer)
    {
        $this->customer = $customer;
    }

    #[On('customer-selected')]
    public function render()
    {
        $isCustomerSelected = $this->customer !== null;

        if ($isCustomerSelected) {
            $receipts = $this->customer->receipts->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $receipts = Receipt::orderBy('updated_at', 'desc')->paginate(10);

        }
        $data=[
            'receipts'=>$receipts,
        ];
        return view('livewire.receipt.table',$data);
    }
}
