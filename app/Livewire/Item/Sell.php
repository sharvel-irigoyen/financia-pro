<?php

namespace App\Livewire\Item;

use App\Models\Customer;
use App\Models\Item;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Sell extends Component
{
    public $isCredit;

    public $installments=1;

    #[Validate('required|in:Parcial,Total', as:'tipo de periodo de gracia')]
    public $grace_period_type='Ninguno';

    #[Validate('required|integer|min:0|max:3 ', as:'periodo de gracia')]
    public $grace_period=0;

    public $interest;

    public $installment;

    public $total;

    public ?Item $item=null;
    public ?Customer $customer=null;

    #[On('item-selected')]
    public function handleItemSelected(Item $item)
    {
        $this->item=$item;
    }

    #[On('customer-selected')]
    public function handleCustomerSelected(Customer $customer)
    {
        $this->customer=$customer;
    }

    public function sell()
    {
        if (!$this->validateItemCustomer()) {
            return;
        }

        $receipt=$this->customer->receipts()->create([
            'subtotal'=>$this->item->price,
            'interest_total'=>0,
            'status'=>1,
            'total'=>$this->item->price,
            'payment_date'=>now(),
        ]);

        $receipt->receiptDetails()->create([
            'item_id'=>$this->item->id,
            'issue_date'=>now(),
            'total_installment'=>0,
            'grace_period_type'=>'Ninguno',
            'grace_period'=>0,
        ]);

        $receipt->paymentDetails()->create([
            'issue_date'=>now(),
            'amount'=>$this->item->price,
        ]);
    }

    public function giveCredit()
    {
        if (!$this->validateItemCustomer()) {
            return;
        }

        $this->validate([
            'installments' => 'required|integer|min:1',
            'grace_period_type' => 'required|in:Parcial,Total,Ninguno',
            'grace_period' => 'required|integer|min:0|max:3',
        ]);

        $this->calculateInterest();

        $receipt = $this->customer->receipts()->create([
            'subtotal' => $this->item->price,
            'interest_total' => $this->interest,
            'status' => 0, // Pendiente
            'total' => $this->total,
            'payment_date' => now(),
        ]);

        $receiptDetails = $receipt->receiptDetails()->create([
            'item_id' => $this->item->id,
            'issue_date' => now(),
            'total_installment' => $this->installments,
            'grace_period_type' => $this->grace_period_type,
            'grace_period' => $this->grace_period,
        ]);

        $this->customer->creditAccount()->increment('balance', $this->total);

        $creditAccount = $this->customer->creditAccount;

        $interestRate = $creditAccount->interest_rate;
        $creditType = $creditAccount->credit_type;
        $TEA = ($creditType === 'TNA') ? pow(1 + $interestRate / 365, 365) - 1 : $interestRate;

        $TEM = pow(1 + $TEA, 1 / 12) - 1;

        $remaining_balance = $this->item->price;
        for ($i = 1; $i <= $this->installments; $i++) {
            $payment_date = now()->addMonths($i);

            $interest_amount = $remaining_balance * $TEM;
            $amortization = $this->installment - $interest_amount;

            if ($this->grace_period_type != 'Ninguno') {
                $amortization = 0;
                if ($this->grace_period_type === 'Total' && $i <= $this->grace_period) {
                    $this->installment = 0;
                } elseif ($this->grace_period_type === 'Parcial' && $i <= $this->grace_period) {
                    $this->installment = round($interest_amount, 2);
                }
            } else {
                $this->installment = round($this->installment, 2);
            }

            $remaining_balance -= $amortization;

            $receiptDetails->paymentPlans()->create([
                'installment_number' => $i,
                'payment_date' => $payment_date,
                'is_period_grace' => $this->grace_period_type != 'Ninguno' && $i <= $this->grace_period,
                'is_overdue' => false,
                'interest_amount' => round($interest_amount, 2),
                'amortization' => round($amortization, 2),
                'installment' => $this->installment,
            ]);
        }
    }

    public function updatedInstallments()
    {
        $this->validate([
            'installments' => 'required|integer|min:1',
        ]);
        if ($this->validateItemCustomer()) {
            $this->calculateInterest();
        }
    }

    public function updatedIsCredit()
    {
        if ($this->validateItemCustomer()) {
            $this->calculateInterest();
        }
    }

    private function calculateInterest()
    {
        $creditAccount = $this->customer->creditAccount;
        $interestRate = $creditAccount->interest_rate;
        $creditType = $creditAccount->credit_type;

        // Calcular la TEA
        if ($creditType === 'TNA') {
            $TEA = pow(1 + $interestRate / 365, 365) - 1;
        } else {
            $TEA = $interestRate;
        }

        // Calcular la TEM
        $TEM = pow(1 + $TEA, 1 / 12) - 1;

        $subtotal = $this->item->price;
        $n = $this->installments;

        // Calcular la cuota mensual constante usando el método francés
        $this->installment = round($subtotal * ($TEM * pow(1 + $TEM, $n)) / (pow(1 + $TEM, $n) - 1), 2);

        // Calcular el total a pagar y el interés total
        $total = $this->installment * $n;
        $this->interest = round($total - $subtotal, 2);
        $this->total = round($total, 2);
    }

    private function validateItemCustomer(): bool
    {
        if (!$this->item) {
            $this->addError('item', 'Item no seleccionado');
            return false;
        }

        if (!$this->customer) {
            $this->addError('customer', 'Cliente no seleccionado');
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.item.sell');
    }
}
