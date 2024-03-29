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

    #[Validate('required|date_format:Y-m-d', as:'fecha de pago')]
    public $paymentDate;

    #[Validate('required|numeric|between:0,1', as:'tasa de interés')]
    public $interestRate;

    #[Validate('required|numeric|between:0,1', as:'tasa de penalidad')]
    public $penaltyRate;

    #[Validate('required|integer|min:0', as:'límite de crédito')]
    public $creditLimit;

    public Customer $customer;

    public function save()
    {
        $this->validate();
        Customer::create([
            'name'                  => $this->name,
            'lastname'              => $this->lastname,
            'document'              => $this->document,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
            'payment_date'          => $this->paymentDate,
            'interest_rate'         => $this->interestRate,
            'penalty_interest_rate' => $this->penaltyRate,
            'credit_limit'          => $this->creditLimit,
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
            'payment_date'          => $this->paymentDate,
            'interest_rate'         => $this->interestRate,
            'penalty_interest_rate' => $this->penaltyRate,
            'credit_limit'          => $this->creditLimit,
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
        $this->paymentDate=$this->customer->payment_date;
        $this->interestRate=$this->customer->interest_rate;
        $this->penaltyRate=$this->customer->penalty_interest_rate;
        $this->creditLimit=$this->customer->credit_limit;
    }
}
