<?php

namespace App\Livewire\Customer;

use App\Livewire\Forms\CustomerForm;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddModal extends Component
{
    use LivewireAlert;
    public CustomerForm $form;

    public function add()
    {
        $this->form->save();
        $this->dispatch('customer-saved');
        $this->alert('success', 'Nuevo cliente agregado!', [
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'timer' => 1500,
        ]);
    }
    public function render()
    {
        return view('livewire.customer.add-modal');
    }
}
