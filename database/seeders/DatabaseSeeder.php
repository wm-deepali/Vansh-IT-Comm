<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(IndiaStatesCitiesSeeder::class);
        $this->call(AboutPageSeeder::class);
        $this->call(ExchangeSeeder::class);
        $this->call(HomePageSeeder::class);
        $this->call(RepairPageSeeder::class);
        
    }
}
