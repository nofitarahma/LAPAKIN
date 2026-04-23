<?php

namespace Database\Seeders;

use App\Models\TransferAccount;
use Illuminate\Database\Seeder;

class TransferAccountSeeder extends Seeder
{
    public function run(): void
    {
        TransferAccount::updateOrCreate(
            ['account_number' => '1234567890'],
            [
                'bank_name' => 'Bank Mandiri',
                'account_holder_name' => 'PT LAPAKIN Indonesia',
            ]
        );

        TransferAccount::updateOrCreate(
            ['account_number' => '0987654321'],
            [
                'bank_name' => 'Bank BCA',
                'account_holder_name' => 'PT LAPAKIN Indonesia',
            ]
        );

        TransferAccount::updateOrCreate(
            ['account_number' => '5555666677'],
            [
                'bank_name' => 'Bank BNI',
                'account_holder_name' => 'PT LAPAKIN Indonesia',
            ]
        );
    }
}
