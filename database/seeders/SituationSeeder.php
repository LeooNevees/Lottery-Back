<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SituationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('situation')->insert([
            'description' => 'ATIVO',
            'created_at' => now()
        ]);

        DB::table('situation')->insert([
            'description' => 'INATIVO',
            'created_at' => now()
        ]);

        DB::table('situation')->insert([
            'description' => 'EM ANDAMENTO',
            'created_at' => now()
        ]);
    }
}
