<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed in order to respect foreign key constraints
        $this->call([
            SettingsSeeder::class,
            PaymentMethodSeeder::class,
            ShippingMethodSeeder::class,
            PaymentInfoSeeder::class,
        ]);
    }
}
