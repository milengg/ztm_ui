<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Updates;

class UpdatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $updates = [
            [
                'service' => 'ztmUI',
                'status' => false
            ],
            [
                'service' => 'zoneID',
                'status' => false
            ],
            [
                'service' => 'zontromat',
                'status' => false
            ],
        ];
        Updates::insert($updates);
    }
}
