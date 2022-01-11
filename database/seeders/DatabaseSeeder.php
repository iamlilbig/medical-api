<?php

namespace Database\Seeders;

use App\Models\MassageType;
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
        // \App\Models\User::factory(10)->create();
        MassageType::query()->create(['massage_type'=>'register']);
    }
}
