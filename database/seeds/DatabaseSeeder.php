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
        $this->call(UsersSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PostTypesSeeder::class);
        $this->call(PermissablesSeeder::class);
        $this->call(UserPermissionsSeeder::class);
        //$this->call(PermissionModesSeeder::class);
    }
}
