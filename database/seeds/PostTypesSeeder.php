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
            'icon' => 'chrome_reader_mode',
            'model' => 'Post',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Announcement',
            'slug' => 'announcements',
            'icon' => 'chrome_reader_mode',
            'model' => 'Post',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Group',
            'slug' => 'groups',
            'model' => 'Group',
            'icon' => 'group',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Task',
            'slug' => 'tasks',
            'model' => 'Task',
            'icon' => 'rowing',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Post Type',
            'slug' => 'post-types',
            'icon' => '',
            'model' => 'Post',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Permissisons',
            'slug' => 'permissions',
            'icon' => '',
            'model' => 'Permission',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Permission Types',
            'slug' => 'permission-types',
            'icon' => '',
            'model' => 'Permission',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Permission Modes',
            'slug' => 'permission-modes',
            'icon' => '',
            'model' => 'Permission',
            'created_at' => $createdAt,
        ]);
    }
}
