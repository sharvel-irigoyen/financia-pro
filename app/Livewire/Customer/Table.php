<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $listeners = [
        'delete'
    ];

    public Customer $customer;
    public function deleteConfirmation(Customer $customer)
    {
        $this->customer=$customer;
        $this->alert('warning', '¿Estás seguro que deseas eliminar este cliente?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
            'onConfirmed' => 'delete',
            'showCancelButton' => true,
            'cancelButtonText' => 'No',
            'toast' => false,
            'position' => 'center',
            'timer' => null,
        ]);
    }
    public function delete()
    {
        $this->customer->delete();
        $this->alert('success', 'cliente eliminado', [
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'timer' => 1500,
        ]);

    }
    public function render()
    {
        $data=[
            'customers'=>Customer::orderBy('updated_at')
            ->paginate(10),
        ];
        return view('livewire.customer.table', $data);
    }
}
