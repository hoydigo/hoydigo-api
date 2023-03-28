<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('states')->insert(['id' => 5, 'country_id' => 'COL', 'name' => 'ANTIOQUIA']);
            DB::table('states')->insert(['id' => 8, 'country_id' => 'COL', 'name' => 'ATLÁNTICO']);
            DB::table('states')->insert(['id' => 11, 'country_id' => 'COL', 'name' => 'BOGOTÁ, D.C.']);
            DB::table('states')->insert(['id' => 13, 'country_id' => 'COL', 'name' => 'BOLÍVAR']);
            DB::table('states')->insert(['id' => 15, 'country_id' => 'COL', 'name' => 'BOYACÁ']);
            DB::table('states')->insert(['id' => 17, 'country_id' => 'COL', 'name' => 'CALDAS']);
            DB::table('states')->insert(['id' => 18, 'country_id' => 'COL', 'name' => 'CAQUETÁ']);
            DB::table('states')->insert(['id' => 19, 'country_id' => 'COL', 'name' => 'CAUCA']);
            DB::table('states')->insert(['id' => 20, 'country_id' => 'COL', 'name' => 'CESAR']);
            DB::table('states')->insert(['id' => 23, 'country_id' => 'COL', 'name' => 'CÓRDOBA']);
            DB::table('states')->insert(['id' => 25, 'country_id' => 'COL', 'name' => 'CUNDINAMARCA']);
            DB::table('states')->insert(['id' => 27, 'country_id' => 'COL', 'name' => 'CHOCÓ']);
            DB::table('states')->insert(['id' => 41, 'country_id' => 'COL', 'name' => 'HUILA']);
            DB::table('states')->insert(['id' => 44, 'country_id' => 'COL', 'name' => 'LA GUAJIRA']);
            DB::table('states')->insert(['id' => 47, 'country_id' => 'COL', 'name' => 'MAGDALENA']);
            DB::table('states')->insert(['id' => 50, 'country_id' => 'COL', 'name' => 'META']);
            DB::table('states')->insert(['id' => 52, 'country_id' => 'COL', 'name' => 'NARIÑO']);
            DB::table('states')->insert(['id' => 54, 'country_id' => 'COL', 'name' => 'NORTE DE SANTANDER']);
            DB::table('states')->insert(['id' => 63, 'country_id' => 'COL', 'name' => 'QUINDIO']);
            DB::table('states')->insert(['id' => 66, 'country_id' => 'COL', 'name' => 'RISARALDA']);
            DB::table('states')->insert(['id' => 68, 'country_id' => 'COL', 'name' => 'SANTANDER']);
            DB::table('states')->insert(['id' => 70, 'country_id' => 'COL', 'name' => 'SUCRE']);
            DB::table('states')->insert(['id' => 73, 'country_id' => 'COL', 'name' => 'TOLIMA']);
            DB::table('states')->insert(['id' => 76, 'country_id' => 'COL', 'name' => 'VALLE DEL CAUCA']);
            DB::table('states')->insert(['id' => 81, 'country_id' => 'COL', 'name' => 'ARAUCA']);
            DB::table('states')->insert(['id' => 85, 'country_id' => 'COL', 'name' => 'CASANARE']);
            DB::table('states')->insert(['id' => 86, 'country_id' => 'COL', 'name' => 'PUTUMAYO']);
            DB::table('states')->insert(['id' => 88, 'country_id' => 'COL', 'name' => 'ARCHIPIÉLAGO DE SANANDRÉS, PROVIDENCIA Y SANTA CATALINA']);
            DB::table('states')->insert(['id' => 91, 'country_id' => 'COL', 'name' => 'AMAZONAS']);
            DB::table('states')->insert(['id' => 94, 'country_id' => 'COL', 'name' => 'GUAINÍA']);
            DB::table('states')->insert(['id' => 95, 'country_id' => 'COL', 'name' => 'GUAVIARE']);
            DB::table('states')->insert(['id' => 97, 'country_id' => 'COL', 'name' => 'VAUPÉS']);
            DB::table('states')->insert(['id' => 99, 'country_id' => 'COL', 'name' => 'VICHADA']);

        } catch (\Throwable $e) {
            Log::error(
            'States Seeder, ' .
            'error: ' . $e->getMessage()
            );
        }

    }
}
