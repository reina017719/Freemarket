<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'payment_type' => 'コンビニ払い'
        ];
        DB::table('payments')->insert($param);
        $param = [
            'payment_type' => 'カード支払い'
        ];
        DB::table('payments')->insert($param);
    }
}
