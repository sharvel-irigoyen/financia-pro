<?php

namespace App\Livewire\Item;

use App\Models\Category;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditModal extends Component
{
    use LivewireAlert;

    public Item $item;

    #[Validate('required', as: 'código')]
    public $code;

    #[Validate('required', as: 'categoría')]
    public $categoryId;

    #[Validate('required', as: 'descripción')]
    public $description;

    #[Validate('required', as: 'precio')]
    public $price;

    public function mount()
    {
        $this->code=$this->item->code;
        $this->categoryId=$this->item->category->id;
        $this->description=$this->item->description;
        $this->price=$this->item->price;
    }
    public function edit()
    {
        $this->validate();
        $this->item->update([
            'code' => $this->code,
            'category_id' => $this->categoryId,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        $this->dispatch('item-saved');
        $this->alert('success', 'Producto editado!', [
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'timer' => 1500,
        ]);
    }
    public function render()
    {
        $data=[
            'categories' => Category::all(),
        ];
        return view('livewire.item.edit-modal', $data);
    }
}
