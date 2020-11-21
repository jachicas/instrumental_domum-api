<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function __construct(User $user)
    {
        $this->users = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->users->create([
            'name' => 'Usuario',
            'last_name' => 'Test',
            'email' => 'user@gmail.com',
            'password' => Hash::make('qwerty123')
        ]);

        $user->assignRole('user');

        $users = $this->users->factory()->count(20)->create();

        $users->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
