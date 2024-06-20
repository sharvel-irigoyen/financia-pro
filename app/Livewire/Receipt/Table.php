<?php

namespace App\Livewire\Receipt;

use App\Models\Receipt;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public function render()
    {
        $data=[
            'receipts'=>Receipt::orderBy('updated_at', 'desc')->paginate(10),
        ];
        return view('livewire.receipt.table',$data);
    }
}
