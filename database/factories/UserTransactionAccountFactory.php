<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserTransactionAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTransactionAccountFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = UserTransactionAccount::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'balance' => $this->faker->randomFloat(2, 100, 400),
        ];
    }
}
