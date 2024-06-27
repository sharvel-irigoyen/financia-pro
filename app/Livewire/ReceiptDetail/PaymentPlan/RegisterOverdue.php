<?php

namespace App\Livewire\ReceiptDetail\PaymentPlan;

use App\Models\PaymentPlan;
use App\Models\ReceiptDetail;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterOverdue extends Component
{
    public $nInstallment='';
    public $installments=[];

    public $TEM;

    public ?ReceiptDetail $receiptDetail = null;

    #[On('payment-plan-loaded')]
    public function handleCustomerSelected(?ReceiptDetail $receiptDetail)
    {
        $this->receiptDetail = $receiptDetail;
        $paymentPlans = $receiptDetail?->paymentPlans ?? [];

        $this->installments = $paymentPlans?->pluck('installment_number', 'installment_number')->all() ?? [];
        $this->calculateTem();
    }


    public function makeOverdue()
    {
        $paymentPlan = $this->receiptDetail->paymentPlans()->where('installment_number', $this->nInstallment)->first();

        if ($paymentPlan) {
            $paymentPlan->update([
                'is_overdue' => true,
            ]);

            $remaining_balance = $this->receiptDetail->item->price;

            foreach ($this->receiptDetail->paymentPlans as $i => $plan) {
                $payment_date = now()->addMonths($i + 1);
                $isPeriodGrace = $i + 1 <= $this->receiptDetail->grace_period;

                // Calcular el registro de pago para la cuota actual
                $paymentRecord = $this->calculateInstallment($remaining_balance, $i + 1, $isPeriodGrace);

                // dump($paymentRencord);

                $plan->update([
                    'interest_amount' => round($paymentRecord['interest'], 2),
                    'amortization' => round($paymentRecord['amortization'], 2),
                    'remaining_balance' => round($paymentRecord['remaining_balance'], 2),
                    'installment' => round($paymentRecord['installment'], 2),
                ]);

                $remaining_balance = $paymentRecord['remaining_balance'];
            }

            $this->dispatch('make-overdue')->to(Table::class);
        }
    }


    public function calculateTem()
    {
        $creditAccount = $this->receiptDetail->receipt->customer->creditAccount;
        $interestRate = $creditAccount->interest_rate;
        $creditType = $creditAccount->credit_type;
        $TEA = ($creditType === 'TNA') ? pow(1 + $interestRate / 365, 365) - 1 : $interestRate;
        $TEM = pow(1 + $TEA, 1 / 12) - 1;
        $this->TEM = $TEM;
    }

    public function calculateInstallment($remaining_balance, $n, $isPeriodGrace = false)
    {
        $installments = count($this->installments);
        $installmentRemaining = $installments - $n + 1;
        $gracePeriodType = $this->receiptDetail->grace_period_type;
        $isOverdue= $this->receiptDetail->paymentPlans()->where('installment_number', $n)->first()->is_overdue;

        $interest=$remaining_balance * $this->TEM;

        if ($gracePeriodType=='Total' && $isPeriodGrace) {
            $amortization=0;
            $installment=0;
            $remaining_balance += $interest;
        } elseif ($gracePeriodType=='Total' && !$isPeriodGrace && $isOverdue) {
            $amortization=0;
            $installment=round($remaining_balance * ($this->TEM * pow(1 + $this->TEM, $installmentRemaining)) / (pow(1 + $this->TEM, $installmentRemaining) - 1), 2);
            $remaining_balance += $interest;
        } elseif ($gracePeriodType=='Total' && !$isPeriodGrace && !$isOverdue) {
            $installment=round($remaining_balance * ($this->TEM * pow(1 + $this->TEM, $installmentRemaining)) / (pow(1 + $this->TEM, $installmentRemaining) - 1), 2);
            $amortization=$installment - $interest;
            $remaining_balance -= $amortization;
        }

        if ($gracePeriodType=='Parcial' && $isPeriodGrace) {
            $amortization=0;
            $installment = $interest;
        } elseif ($gracePeriodType=='Parcial' && !$isPeriodGrace && $isOverdue) {
            $amortization=0;
            $installment=round($remaining_balance * ($this->TEM * pow(1 + $this->TEM, $installmentRemaining)) / (pow(1 + $this->TEM, $installmentRemaining) - 1), 2);
            $remaining_balance += $interest;
        } elseif ($gracePeriodType=='Parcial' && !$isPeriodGrace && !$isOverdue) {
            $installment=round($remaining_balance * ($this->TEM * pow(1 + $this->TEM, $installmentRemaining)) / (pow(1 + $this->TEM, $installmentRemaining) - 1), 2);
            $amortization=$installment - $interest;
            $remaining_balance -= $amortization;
        }

        if ($gracePeriodType=='Ninguno' && $isOverdue) {
            $amortization=0;
            $installment=round($remaining_balance * ($this->TEM * pow(1 + $this->TEM, $installmentRemaining)) / (pow(1 + $this->TEM, $installmentRemaining) - 1), 2);
            $remaining_balance += $interest;
        } elseif ($gracePeriodType=='Ninguno' && !$isOverdue) {
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

    public function render()
    {
        return view('livewire.receipt-detail.payment-plan.register-overdue');
    }
}
