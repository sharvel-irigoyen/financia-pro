<?php

namespace App\Livewire\Category;

use App\Models\Category;
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
    public Category $category;

    public function deleteConfirmation(Category $category)
    {
        $this->category = $category;
        $this->alert('warning', '¿Estás seguro que deseas eliminar esta categoría?', [
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
            $this->category->delete();
            $this->alert('success', 'Categoría eliminada', [
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
            'categories' => Category::paginate(5),
        ];
        return view('livewire.category.table', $data);
    }
}
