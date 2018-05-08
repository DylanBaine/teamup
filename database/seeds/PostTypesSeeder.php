<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;

class PostTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = Carbon::now()->toDateTimeString();
        DB::table('types')->insert([
            'name' => 'Documentation',
            'slug' => 'documentations',
            'model' => 'Post',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Announcement',
            'slug' => 'announcements',
            'model' => 'Post',
            'created_at' => $createdAt,
        ]);

    }
}
