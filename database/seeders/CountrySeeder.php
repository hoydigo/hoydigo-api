<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('countries')->insert([
                'id' => 'COL',
                'name' => 'Colombia',
                'continent' => 'América del Sur',
            ]);

        } catch (\Throwable $e) {
            Log::error(
                'Countries Seeder, ' .
                'error: ' . $e->getMessage()
            );
        }
    }
}
