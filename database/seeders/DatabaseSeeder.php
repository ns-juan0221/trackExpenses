<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call([
            IncomeCategorySeeder::class,
            OutcomeMainCategorySeeder::class,
            OutcomeSubCategorySeeder::class,
            UserSeeder::class,
            IncomeSeeder::class,
            OutcomeSeeder::class,
        ]);
    }
}
