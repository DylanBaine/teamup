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
        $docsOnly = 4;
        // Permission modes
        $create = 1;
        $read = 2;
        $update = 3;
        $delete = 4;
        $manage = 5;
        $assign = 6;
        // Types
        $documentation = 1;
        $announcement = 2;
        $groups = 3;
        $tasks = 4;
        $postTypes = 5;
        $permissions = 6;
        $permissionTypes = 7;
        $permissionModes = 8;
        $sprint = 9;
        $support = 10;

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

        $this->make($dylan, $create, $postTypes);

        $this->make($dylan, $create, $permissions);
        $this->make($dylan, $read, $permissions);
        $this->make($dylan, $manage, $permissions);
        $this->make($dylan, $assign, $permissions);
        $this->make($dylan, $create, $permissionTypes);
        $this->make($dylan, $create, $permissionModes);

        $this->make($taskOnly, $read, $tasks);

        $this->make($groupOnly, $read, $groups);

        $this->make($docsOnly, $read, $documentation);

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
