<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Nataniel Otero',
            'email' => 'natanielotero@gmail.com',
            'password' => '123456',
            'isAdmin' => true
            
            
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Himeko',
            'email' => 'ExpressQueen@booba.com',
            'password' => '123456',
            'isAdmin' => false
            
            
        ]);
        \App\Models\User::factory()->create([
            'name' => 'March 7th',
            'email' => 'BestoGirl@cutiepie.com',
            'password' => '123456',
            'isAdmin' => false
            
            
        ]);

        \App\Models\Classroom::factory()->create([
            'name' => 'Clase 1',
            'quota' => 45
        ]);
    }
}
