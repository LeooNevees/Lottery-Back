<?php

namespace Database\Seeders;

use App\Jobs\ProcessSortition;
use App\Models\Sortition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SortitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sortition = Sortition::create([
            'situation_id' => 3,
        ]);

        ProcessSortition::dispatch(['id' => $sortition->id]);
    }
}
