<?php

namespace Database\Seeders;

use App\Models\Waiting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WaitingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Waiting::factory(3)->create();
    }
}
