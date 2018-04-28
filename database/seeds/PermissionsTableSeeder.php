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
        DB::table('permissions')->insert([
            'mode' => 'create',
        ]);

        DB::table('permissions')->insert([
            'mode' => 'read',
        ]);

        DB::table('permissions')->insert([
            'mode' => 'update',
        ]);

        DB::table('permissions')->insert([
            'mode' => 'delete',
        ]);
        
    }
}
