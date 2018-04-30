<?php

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
        //$this->call(UsersSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PostTypesSeeder::class);
        factory(App\Models\User::class, 1)->create([
            'name'=>'Dylan',
            'email'=>'dylan.baine@yahoo.com'
        ]);
    }
}
