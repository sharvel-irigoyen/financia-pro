<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{
    #[Validate('required', as: 'nombres')]
    public $name;

    #[Validate('required', as:'apellidos')]
    public $lastname;

    #[Validate('required', as:'documento')]
    public $document;

    #[Validate('required|unique:users|email:filter')]
    public $email;

    #[Validate('required|digits:9')]
    public $phone;

    #[Validate('required|in:TEA,TNA', as:'tipo de crédito')]
    public $creditType='';

    #[Validate('required|numeric|between:0,1', as:'tasa de interés')]
    public $interestRate;

    #[Validate('required|integer', as:'día de pago')]
    public $paymentDate;

    #[Validate('required|integer|min:100', as:'límite de crédito')]
    public $creditLimit;

    public Customer $customer;

    public function save()
    {
        $this->validate();
        $customer=Customer::create([
            'name'                  => $this->name,
            'lastname'              => $this->lastname,
            'document'              => $this->document,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
        ]);

        $customer->creditAccount()->create([
            'credit_type' => $this->creditType,
            'interest_rate' => $this->interestRate,
            'balance' => 0,
            'due_date' => $this->paymentDate,
            'credit_limit' => $this->creditLimit,
        ]);
    }

    public function update()
    {
        $this->validate();
        $this->customer->update([
            'name'                  => $this->name,
            'lastname'              => $this->lastname,
            'document'              => $this->document,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
        ]);
        $this->customer->creditAccount->update([
            'credit_type' => $this->creditType,
            'interest_rate' => $this->interestRate,
            'due_date' => $this->paymentDate,
            'credit_limit' => $this->creditLimit,
        ]);
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer=$customer;
        $this->name=$this->customer->name;
        $this->lastname=$this->customer->lastname;
        $this->document=$this->customer->document;
        $this->email=$this->customer->email;
        $this->phone=$this->customer->phone;
        $this->creditType=$this->customer->creditAccount->credit_type;
        $this->interestRate=$this->customer->creditAccount->interest_rate;
        $this->balance=$this->customer->creditAccount->balance;
        $this->paymentDate=$this->customer->creditAccount->due_date;
        $this->creditLimit=$this->customer->creditAccount->credit_limit;
    }
}
