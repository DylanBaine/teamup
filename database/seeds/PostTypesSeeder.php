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
            'slug' => 'documentations',
        ]);
        DB::table('types')->insert([
            'name' => 'Announcement',
            'slug' => 'announcements',
        ]);

    }
}
