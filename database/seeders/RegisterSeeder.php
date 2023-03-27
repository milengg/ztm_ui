<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Register;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Register::truncate();

        $csvFile = fopen(base_path("database/registers/registers.csv"), "r");

        $firstline = true;
        while(($data = fgetcsv($csvFile, 2000, ",")) !== FALSE)
        {
            if(!$firstline) 
            {
                Register::create([
                    "name" => $data['0'],
                    "type" => $data['1'],
                    "range" => $data['2'],
                    "plugin" => $data['3'],
                    "scope" => $data['4'],
                    "default" => $data['5'],
                    "description" => $data['6'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
