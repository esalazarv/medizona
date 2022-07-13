<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Root',
            'email' => 'root@medizona.com',
            'password' => 'secret'
        ]);
    }
}
