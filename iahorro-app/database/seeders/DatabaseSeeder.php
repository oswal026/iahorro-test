<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            //Experts
            DB::table('experts')->insert([
                'first_name' => Str::random(10),
                'last_name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'phone' => Str::random(9),
            ]);
        }

        //Time Zones
        $from = $to = new \DateTime('NOW');
        for ($i = 1; $i <= 2; $i++) {
            DB::table('time_zones')->insert([
                'from' => $from->setTime($i*8, 00, 00)->format('H:i'),
                'to' => $to->setTime(($i * 8) + 5, 00, 00)->format('H:i'),
            ]);
        }
    }
}
