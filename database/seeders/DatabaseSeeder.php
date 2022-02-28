<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Task;
use App\Models\User;
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
        User::create([
            'name' => 'sm',
            'email'=> 'sm@sm.sm',
            'password' => bcrypt('123'),
            'thumbnail' => 'https://picsum.photos/300'
        ]);

        Client::factory(50)->create();
        Task::factory(50)->create();
    }
}
