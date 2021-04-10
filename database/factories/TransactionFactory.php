<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\UserTransactionAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => UserTransactionAccount::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 400),
            'type' => $this->faker->boolean() ? Transaction::DEBIT_TYPE : Transaction::CREDIT_TYPE,
        ];
    }
}
