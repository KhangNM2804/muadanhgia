<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class db_seed_types extends Seeder
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
                'name' => "Via",
            ],
            [
                'name' => "Via Mỹ - USA",
            ],
            [
                'name' => "Via Đức",
            ],
            [
                'name' => "Via Philippines",
            ],
            [
                'name' => "Via việt nam",
            ],
            [
                'name' => "Via indonesia",
            ],
            [
                'name' => "Via thái lan",
            ],
            [
                'name' => "Clone",
            ],
            [
                'name' => "Bm",
            ],
            [
                'name' => "Mail",
            ],
        ]);
    }
}
