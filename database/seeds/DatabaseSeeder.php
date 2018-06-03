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
        $this->call(PostTypesSeeder::class);
        $this->call(UserPermissionsSeeder::class);
        $this->call(PermissionModesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(UsersGroupsSeeder::class);
        $this->call(TaskTypesSeeder::class);
    }
}
