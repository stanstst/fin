<?php

namespace Database\Seeders;

use App\Models\UserTransactionAccount;
use Illuminate\Database\Seeder;

class UserTransactionAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        UserTransactionAccount::factory()
            ->count(10)
            ->create();
    }
}
