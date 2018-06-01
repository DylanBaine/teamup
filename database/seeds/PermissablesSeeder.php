<?php

use Illuminate\Database\Seeder;

class PermissablesSeeder extends Seeder
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

        // Types
        $documentation = 1;
        $announcement = 2;
        $groups = 3;
        $tasks = 4;

        // Permission modes
        $create = 1;
        $read = 2;
        $update = 3;
        $delete = 4;

        // user 1 CRUD permissions
        $this->make($dylan, $create, 'Post');
        $this->make($dylan, $read, 'Post');
        $this->make($dylan, $update, 'Post');
        $this->make($dylan, $delete, 'Post');

        $this->make($dylan, $create, 'Group');
        $this->make($dylan, $read, 'Group');
        $this->make($dylan, $update, 'Group');
        $this->make($dylan, $delete, 'Group');


        // task user permissions
        $this->make($taskOnly, $read, 'Task');

        // group user permissions
        $this->make($groupOnly, $read, 'Group');
    }

    /**
     * @param permissable id of what the permission is being linked to
     * @param permission id of the permission we are linking
     * @param type String of the model we are linking with permission
     */
    protected function make($permissable, $permission, $type = 'Type')
    {
        DB::table('permissables')->insert([
            'permissable_id' => $permissable,
            'permission_id' => $permission,
            'permissable_type' => 'App\Models\\' . $type,
        ]);
    }
}
