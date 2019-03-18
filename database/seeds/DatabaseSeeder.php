<?php

use App\Entry;
use App\User;
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
        // $this->call(UsersTableSeeder::class);
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'admin@example.com'),
            'role' => 'admin',
            'password' => Hash::make(env('ADMIN_PASSWORD', '111111')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        if (! $admin->save()) {
            Log::info('Unable to create admin '.$admin->name, (array)$admin->errors());
        } else {
            Log::info('Created admin "'.$admin->name.'" <'.$admin->email.'>');
        }

        factory(User::class, 14)->create();
        factory(Entry::class, 115)->create();
    }
}
