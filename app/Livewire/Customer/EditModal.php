<?php

namespace App\Livewire\Customer;

use App\Livewire\Forms\CustomerForm;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditModal extends Component
{
    use LivewireAlert;

    public CustomerForm $form;
    public $customer;

    public function mount()
    {
        $this->render();
        $this->form->setCustomer($this->customer);
    }
    public function edit()
    {
        $this->form->update();
        $this->customer->refresh();
        $this->dispatch('customer-saved');
        $this->alert('success', 'Cliente editado!', [
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'timer' => 1500,
        ]);
    }
    public function render()
    {
        return view('livewire.customer.edit-modal');
    }
}
