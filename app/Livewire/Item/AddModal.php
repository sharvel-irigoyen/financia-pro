<?php

namespace App\Livewire\Item;

use App\Models\Category;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddModal extends Component
{
    use LivewireAlert;

    #[Validate('required', as: 'código')]
    public $code;

    #[Validate('required', as: 'categoría')]
    public $categoryId='';

    #[Validate('required', as: 'descripción')]
    public $description;

    #[Validate('required', as: 'precio')]
    public $price;

    public function add()
    {
        $this->validate();

        Item::create([
            'code' => $this->code,
            'category_id' => $this->categoryId,
            'description' => $this->description,
            'price' => $this->price,
        ]);
        $this->reset();

        $this->dispatch('item-saved');
        $this->alert('success', 'Nuevo producto agregado!', [
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
        return view('livewire.item.add-modal', $data);
    }
}
