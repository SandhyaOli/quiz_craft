<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create(['name' => 'Sabita Amatya', 'email' => 'swtsandhya409@gmail.com']);
        Student::create(['name' => 'Rita Dangi', 'email' => 'olisandhya707@gmail.com']);
    }
}
