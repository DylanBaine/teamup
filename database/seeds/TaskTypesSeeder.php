<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskTypesSeeder extends Seeder
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
            'name' => 'Sprint',
            'slug' => 'sprints',
            'icon' => 'rowing',
            'model' => 'Task',
            'created_at' => $createdAt,
        ]);
        DB::table('types')->insert([
            'name' => 'Support',
            'slug' => 'supports',
            'icon' => 'rowing',
            'model' => 'Task',
            'created_at' => $createdAt,
        ]);
    }
}
