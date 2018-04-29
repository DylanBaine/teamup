<?php

use Illuminate\Database\Seeder;

class PostTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name' => 'Documentation',
        ]);
        DB::table('types')->insert([
            'name' => 'Announcement',
        ]);

    }
}
