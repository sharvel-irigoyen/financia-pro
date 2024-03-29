<?php

namespace App\Livewire\Item;

use App\Models\Item;
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
    public Item $item;

    public function deleteConfirmation(Item $item)
    {
        $this->item = $item;
        $this->alert('warning', '¿Estás seguro que deseas eliminar este producto?', [
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
        try {
            $this->item->delete();
            $this->alert('success', 'Producto eliminado', [
                'toast' => false,
                'position' => 'center',
                'timerProgressBar' => true,
                'timer' => 1500,
            ]);
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1451) {
                $this->alert('error', 'No puedes eliminar este registro debido a que existen tablas asociados a este', [
                    'toast' => false,
                    'position' => 'center',
                    'timerProgressBar' => true,
                    'timer' => 4000,
                ]);
            }
        }
    }
    public function render()
    {
        $data=[
            'items' => Item::paginate(10),
        ];
        return view('livewire.item.table', $data);
    }
}
