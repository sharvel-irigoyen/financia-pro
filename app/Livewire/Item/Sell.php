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
    public $installments = 1;

    #[Validate('required', as: 'tipo de periodo de gracia')]
    public $grace_period_type = 'Ninguno';

    #[Validate('required|integer|min:0|max:3', as: 'periodo de gracia')]
    public $grace_period = 0;

    public $interest;
    public $installment;
    public $total;

    public $firstInstallmentDate;
    public $lastInstallmentDate;

    public $TEM;


    public ?Item $item = null;
    public ?Customer $customer = null;


    #[On('item-selected')]
    public function handleItemSelected(Item $item)
    {
        $this->item = $item;
    }

    #[On('customer-selected')]
    public function handleCustomerSelected(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function calculateTem()
    {
        $creditAccount = $this->customer->creditAccount;
        $interestRate = $creditAccount->interest_rate;
        $creditType = $creditAccount->credit_type;
        $TEA = ($creditType === 'TNA') ? pow(1 + $interestRate / 365, 365) - 1 : $interestRate;
        $TEM = pow(1 + $TEA, 1 / 12) - 1;
        $this->TEM = $TEM;
    }

    public function sell()
    {
        if (!$this->validateItemCustomer()) {
            return;
        }

        $receipt = $this->customer->receipts()->create([
            'subtotal' => $this->item->price,
            'interest_total' => 0,
            'status' => 1,
            'total' => $this->item->price,
            'payment_date' => now(),
        ]);

        $receipt->receiptDetails()->create([
            'item_id' => $this->item->id,
            'issue_date' => now(),
            'total_installment' => 0,
            'grace_period_type' => 'Ninguno',
            'grace_period' => 0,
        ]);

        $receipt->paymentDetails()->create([
            'issue_date' => now(),
            'amount' => $this->item->price,
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

        // Calcular el total a pagar y el interés total

        $this->updateTotals();

        $receipt = $this->customer->receipts()->create([
            'subtotal' => $this->item->price,
            'interest_total' => $this->interest,
            'status' => 0, // Pendiente
            'total' => $this->total,
            'payment_date' => now()->addMonths($this->installments)->setDay($this->customer->creditAccount->due_date),
        ]);

        $receiptDetails = $receipt->receiptDetails()->create([
            'item_id' => $this->item->id,
            'issue_date' => now(),
            'total_installment' => $this->installments,
            'grace_period_type' => $this->grace_period_type,
            'grace_period' => $this->grace_period,
        ]);

        $this->customer->creditAccount()->increment('balance', $this->total);

        $remaining_balance = $this->item->price;
        for ($i = 1; $i <= $this->installments; $i++) {
            $payment_date = now()->addMonths($i)->setDay($this->customer->creditAccount->due_date);
            $isPeriodGrace = $i <= $this->grace_period;

            // Calcular el registro de pago para la cuota actual
            $paymentRecord = $this->calculateInstallment($remaining_balance, $i, $isPeriodGrace);

            $receiptDetails->paymentPlans()->create([
                'installment_number' => $i,
                'payment_date' => $payment_date,
                'is_period_grace' =>$isPeriodGrace,
                'is_overdue' => false,
                'interest_amount' => round($paymentRecord['interest'], 2),
                'amortization' => round($paymentRecord['amortization'], 2),
                'remaining_balance' => round($paymentRecord['remaining_balance'], 2),
                'installment' => round($paymentRecord['installment'], 2),
            ]);

            $remaining_balance = $paymentRecord['remaining_balance'];
        }
        $this->dispatch('payment-credit-registered');
    }

    public function updatedGracePeriodType()
    {
        $this->validate([
            'grace_period_type' => 'required',
        ]);

        if ($this->validateItemCustomer()) {
            $this->updateTotals();
        }
    }

    public function updatedGracePeriod()
    {
        $this->validate([
            'grace_period' => 'required|integer|min:0|max:3',
        ]);

        if ($this->validateItemCustomer()) {
            $this->updateTotals();
        }
    }

    public function updatedInstallments()
    {
        $this->validate([
            'installments' => 'required|integer|min:1',
        ]);
        if ($this->validateItemCustomer()) {
            $this->updateTotals();
        }
    }

    public function updatedIsCredit()
    {
        if ($this->validateItemCustomer()) {
            $this->updateTotals();
        }
    }

    private function updateTotals()
    {
        $this->calculateTem();
        $totals=$this->calculateTotal();
        $this->interest=round($totals['interest'], 2);
        $this->installment=round($this->calculateInstallment($this->item->price, 1, $this->grace_period)['installment'], 2); //1ra cuota
        $this->total=round($totals['total'], 2);
        $this->firstInstallmentDate=now()->addMonths(1)->setDay($this->customer->creditAccount->due_date);
        $this->lastInstallmentDate=now()->addMonths($this->installments)->setDay($this->customer->creditAccount->due_date);
    }

    public function calculateInstallment($remaining_balance, $n, $isPeriodGrace = false)
    {
        $installments = $this->installments;
        $installmentRemaining = $installments - $n + 1;
        $gracePeriodType = $this->grace_period_type;

        $interest=$remaining_balance * $this->TEM;

        if ($isPeriodGrace) {
            $amortization=0;
            if ($gracePeriodType == 'Total') {
                $installment = 0;
                $remaining_balance += $interest;
            } else {
                $installment = $interest;
            }

        } else {
            $installment=round($remaining_balance * ($this->TEM * pow(1 + $this->TEM, $installmentRemaining)) / (pow(1 + $this->TEM, $installmentRemaining) - 1), 2);

            $amortization=$installment - $interest;
            $remaining_balance -= $amortization;
        }
        return [
            'installment' => $installment,
            'interest' => $interest,
            'amortization'=>$amortization,
            'remaining_balance'=>$remaining_balance
        ];
    }

    private function calculateTotal()
    {
        $remaining_balance = $this->item->price;
        $interest = 0;
        $installment = 0;

        for ($i = 1; $i <= $this->installments; $i++) {
            // Determinar si el pago actual está en el período de gracia
            $isPeriodGrace = $i <= $this->grace_period;

            // Calcular el registro de pago para la cuota actual
            $paymentRecord = $this->calculateInstallment($remaining_balance, $i, $isPeriodGrace);
            // dump($paymentRecord);

            $installment += $paymentRecord['installment'];
            $interest += $paymentRecord['interest'];
            // $amortization = $paymentRecord['amortization'];
            $remaining_balance = $paymentRecord['remaining_balance'];
        }

        return [
            'total' => $installment + $interest,
            'interest' => $interest,
            'installment' => $installment,
        ];
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

        $balance = $this->customer->creditAccount->balance;
        $creditLimit = $this->customer->creditAccount->credit_limit;

        if ($this->isCredit && $balance + $this->item->price > $creditLimit) {
            $this->addError('item', 'El cliente ha excedido su límite de crédito');
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.item.sell');
    }
}
