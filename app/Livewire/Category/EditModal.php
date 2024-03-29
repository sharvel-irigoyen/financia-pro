<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditModal extends Component
{
    use LivewireAlert;

    public Category $category;
    #[Validate('required')]
    public $name;
    public function mount()
    {
        $this->name=$this->category->name;
    }
    public function edit()
    {
        $this->validate();
        $this->category->update([
            'name' => $this->name,
        ]);

        $this->dispatch('category-saved');
        $this->alert('success', 'Categoría editada!', [
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'timer' => 1500,
        ]);
    }
    public function render()
    {
        return view('livewire.category.edit-modal');
    }
}
