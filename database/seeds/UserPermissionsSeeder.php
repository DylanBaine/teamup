<?php

use Illuminate\Database\Seeder;

class UserPermissionsSeeder extends Seeder
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
        // Permission modes
        $create = 1;
        $read = 2;
        $update = 3;
        $delete = 4;
        // Types
        $documentation = 1;
        $announcement = 2;
        $groups = 3;
        $tasks = 4;

        $this->make($dylan, $create, $documentation);
        $this->make($dylan, $read, $documentation);
        $this->make($dylan, $update, $documentation);
        $this->make($dylan, $delete, $documentation);

        $this->make($dylan, $create, $announcement);
        $this->make($dylan, $read, $announcement);
        $this->make($dylan, $update, $announcement);
        $this->make($dylan, $delete, $announcement);

        $this->make($dylan, $create, $groups);
        $this->make($dylan, $read, $groups);
        $this->make($dylan, $update, $groups);
        $this->make($dylan, $delete, $groups);

        $this->make($dylan, $create, $tasks);
        $this->make($dylan, $read, $tasks);
        $this->make($dylan, $update, $tasks);
        $this->make($dylan, $delete, $tasks);

        $this->make($taskOnly, $read, $tasks);

        $this->make($groupOnly, $read, $groups);

    }

    private function make($user, $mode, $type)
    {
        return DB::table('permissions')->insert([
            'user_id' => $user,
            'permission_mode_id' => $mode,
            'type_id' => $type,
        ]);
    }
}
