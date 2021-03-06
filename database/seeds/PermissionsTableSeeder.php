<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_modes')->insert([
            'name' => 'create',
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'read',
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'update',
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'delete',
        ]);
    }
}
