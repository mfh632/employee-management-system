<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fizul Haque',
            'email' => 'mfh632@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'Moin',
            'email' => 'moin@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'Hasan',
            'email' => 'hasan@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'Ferdous',
            'email' => 'ferdous@gmail.com',
        ]);

        $this->call(DesignationsSeeder::class);
        $this->call(DepartmentsSeeder::class);

    }
}
