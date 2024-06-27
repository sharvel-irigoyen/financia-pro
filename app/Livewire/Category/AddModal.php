<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddModal extends Component
{
    use LivewireAlert;

    #[Validate('required|unique:categories', as: 'nombre')]
    public $name;

    public function add()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
        ]);
        $this->reset();

        $this->dispatch('category-saved');
        $this->alert('success', 'Nueva categoría agregada!', [
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'timer' => 1500,
        ]);
    }
    public function render()
    {
        return view('livewire.category.add-modal');
    }
}
