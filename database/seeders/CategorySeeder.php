<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Salary', 'is_expense' => 0], // is_expense = 0 artinya Pemasukan
            ['name' => 'Food & Drink', 'is_expense' => 1], // is_expense = 1 artinya Pengeluaran
            ['name' => 'Transportation', 'is_expense' => 1],
        ]);
    }
}