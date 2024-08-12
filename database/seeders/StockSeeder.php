<?php

namespace Database\Seeders;

use App\Models\Stocks;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stocks::factory()->count(10000)->create();
    }
}
