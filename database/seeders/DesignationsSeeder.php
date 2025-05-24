<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designations')->insert([
            ['name' => 'Chief Executive Officer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chief Technology Officer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Project Manager', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senior Software Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Software Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Junior Software Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Team Lead', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR Manager', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accountant', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales Executive', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
