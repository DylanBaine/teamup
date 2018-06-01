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
            'email' => 'baine@tu.com',
        ]);
        factory(App\Models\User::class, 1)->create([
            'name' => 'Only Documentation',
            'email' => 'docs@tu.com',
        ]);
        factory(App\Models\User::class, 1)->create([
            'name' => 'Only Tasks',
            'email' => 'tasks@tu.com',
        ]);

        factory(App\Models\User::class, 50)->create();
    }
}
