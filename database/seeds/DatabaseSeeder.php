<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
//         $this->call(FestivalsTableSeeder::class);
//         $this->call(FestivalYearsTableSeeder::class);
//         $this->call(VenuesTableSeederMiff::class);
        $this->call(AttributesTableSeederMiff::class);
//         $this->call(FilmsTableSeederMiff::class);
//         $this->call(VenuesTableSeederMqff::class);
//         $this->call(AttributesTableSeederMqff::class);
//         $this->call(FilmsTableSeederMqff::class);
    }
}
