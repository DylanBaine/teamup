<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 1)->create([
            'name' => 'Dylan',
            'email' => 'dylan.baine@yahoo.com',
        ]);

        factory(App\Models\User::class, 50)->create();
    }
}
