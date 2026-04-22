<?php

namespace Database\Seeders;

use App\Models\TransferAccount;
use Illuminate\Database\Seeder;

class TransferAccountSeeder extends Seeder
{
    public function run(): void
    {
        TransferAccount::create([
            'bank_name' => 'Bank Mandiri',
            'account_number' => '1234567890',
            'account_holder_name' => 'PT LAPAKIN Indonesia',
        ]);

        TransferAccount::create([
            'bank_name' => 'Bank BCA',
            'account_number' => '0987654321',
            'account_holder_name' => 'PT LAPAKIN Indonesia',
        ]);

        TransferAccount::create([
            'bank_name' => 'Bank BNI',
            'account_number' => '5555666677',
            'account_holder_name' => 'PT LAPAKIN Indonesia',
        ]);
    }
}
