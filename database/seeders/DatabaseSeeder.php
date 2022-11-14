<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 1000; $i++) {
            DB::table('projects')->insert([
                'employer_id' => 1,
                'category_id' => 7,
                'title' => Str::random(20),
                'description' => Str::random(20),
                'description' => Str::random(300),
                'attachments' => '["toilet.jpeg"]',
                'project_level' => 'Moderate',
                'project_cost_type' => 'Fixed',
                'cost' => 300,
                'project_duration' => '1-5 Days',
                'freelancer_type' => 'Individual',
                'english_level' => 'Basic',
                'skills' => '["32"]',
                'location' => '202 Banahaw, Santa Ana, Manila, Metro Manila, Philippines',
                'latitude' => '14.583564431048188',
                'longitude' => '121.01031202929687',
                'project_type' => 'featured',
                'isExpired' => 0,
                'expiration_date' => '2022-12-02',
                'status' => null,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ]);
        }
    }
}