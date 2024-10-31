<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class db_seed_types2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'name' => "Via Brazil",
            ],
            [
                'name' => "Via Colombia",
            ],
            [
                'name' => "Via Quốc gia random",
            ],
        ]);
    }
}
