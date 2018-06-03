<?php

use Illuminate\Database\Seeder;

class UsersGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        $dylan = 1;
        $taskOnly = 2;
        $groupOnly = 3;
        $docsOnly = 4;
        // Groups
        $admin = 2;
        $user = 1;

        $this->make($dylan, $admin, $user);
        $this->make($taskOnly, $user);
        $this->make($groupOnly, $user);
        $this->make($docsOnly, $user, $admin);
    }

    private function make($user, $group, $second = null)
    {
        DB::table('group_user')->insert([
            'user_id' => $user,
            'group_id' => $group,
        ]);
        if ($second != null) {
            DB::table('group_user')->insert([
                'user_id' => $user,
                'group_id' => $second,
            ]);
        }

    }
}
