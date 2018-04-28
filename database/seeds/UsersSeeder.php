<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 50)->create()->each(function ($u) {
            $u->posts()->save(factory(App\Models\Post::class)->create([
                'user_id' => $u->id,
                'type_id' => rand(1, 2),
            ]));
            for ($i = 1; $i <= 4; $i++) {
                $u->permissions()->attach($i);
            }
            for ($i = 1; $i <= 10; $i++) {
                DB::table('permission_post')->insert([
                    'permission_id' => rand(1, 4),
                    'post_id' => rand(1, 50),
                ]);
            }
            for ($i = 1; $i <= 2; $i++) {
                DB::table('permission_post_type')->insert([
                    'permission_id' => rand(0, 4),
                    'post_type_id' => rand(1, 2),
                ]);
            }

        });
    }
}
