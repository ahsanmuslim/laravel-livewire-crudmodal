<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Student::create([
            'name' => 'Ahmad Susanto',
            'address' => 'Tangerang',
            'email' => 'ahmad@gmail.com',
        ]);
        Student::create([
            'name' => 'Kiki Elbe',
            'address' => 'Tangerang',
            'email' => 'kikielbe@gmail.com',
        ]);
        Student::create([
            'name' => 'Ahsan',
            'address' => 'Tangerang',
            'email' => 'ahsan@gmail.com',
        ]);
    }
}
