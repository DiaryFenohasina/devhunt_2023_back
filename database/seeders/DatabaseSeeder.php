<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\user_seed;

use DB;

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
        $this->call(user_seed::class);
    }
}
