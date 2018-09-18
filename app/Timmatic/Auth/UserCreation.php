<?php
namespace App\Timmatic\Auth;

use App\Models\Company;
use App\Models\User;
use Auth;
use App\Models\PermissionMode;
use DB;
class UserCreation
{

    private $create = [
        'Post Types', 'Tasks', 'Task Types', 'Users', 'Permissions',
        'Documentation', 'Announcements', 'Reports'
    ];
    private $read = [
        'Post Types', 'Tasks', 'Users', 'Permissions',
        'Documentation', 'Announcements', 'Reports', 'Groups', 'Clients', 'Posts'
    ];
    private $update = [
        'Post Types', 'Post Types', 'Tasks', 'Task Types', 'Users', 'Permissions',
        'Documentation', 'Announcements', 'Reports'
    ];
    private $delete = [
        'Post Types', 'Post Types', 'Tasks', 'Task Types', 'Users', 'Permissions',
        'Documentation', 'Announcements', 'Reports'
    ];
    private $manage = [
        'Tasks', 'Users', 'Permissions', 'Groups', 'Clients', 'Posts'
    ];
    private $assign = [
        'Tasks', 'Permissions'
    ];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function response()
    {
        $this->createUser();
        $this->createCompany();
        $this->fillUserRelations();
        return redirect('/app');
    }

    private function createUser()
    {
        $r = $this->request;
        $userData = [
            'name' => $r->name,
            'email' => $r->email,
            'password' => bcrypt($r->password),
            'company_id' => 0,
            'password_confirmed' => 1
        ];
        User::create($userData);
        $this->user = User::with('permissions')->where('email', $r->email)->first();
        Auth::login($this->user);
    }

    private function createCompany()
    {
        $r = $this->request;
        $company = new Company;
        $company->name = $r->companyName;
        $company->super_user_id = $this->user->id;
        $company->plan_id = 1;
        $company->save();
        $this->user->company_id = $company->id;
        $this->user->save();
        $this->companyId = $company->id;
        $this->company = $company;
        $this->user->createDefaultSettings();
    }

    private function fillUserRelations()
    {
        $this->createTypes();
        $this->createPermissions();
    }

    private function createPermissions()
    {
        $this->setupPermissionModes();
        $modes = [
            'create' => $this->company->permissionModes()->where('name', 'create')->first()->id,
            'read' => $this->company->permissionModes()->where('name', 'read')->first()->id,
            'update' => $this->company->permissionModes()->where('name', 'update')->first()->id,
            'delete' => $this->company->permissionModes()->where('name', 'delete')->first()->id,
            'manage' => $this->company->permissionModes()->where('name', 'manage')->first()->id,
            'assign' => $this->company->permissionModes()->where('name', 'assign')->first()->id,
        ];
        foreach($modes as $key => $mode){
            foreach($this->{$key} as $type){
                $type = company()->types()->where('name', $type)->first()->id;
                $this->makePermission($mode, $type);
            }
        }

    }

    private function createTypes()
    {
        /* $this->makeType('Permission Modes', 'Permission', '');
        $this->makeType('Permission Types', 'Permission', '');
        $this->makeType('Posts', 'Permission', 'format_align_left'); */
        $this->makeType('Post Types', 'Permission', 'format_align_left');
        $this->makeType('Permissions', 'Permission', 'supervised_user_circle');
        $this->makeType('Task Types', 'Permission', 'rowing');
        $this->makeType('Tasks', 'Permission', 'rowing');
        $this->makeType('Groups', 'Permission', 'group');
        $this->makeType('Users', 'Permission', 'person');
        $this->makeType('Reports', 'Permission', 'bar_chart');
        $this->makeType('Clients', 'Permission', 'assignment_ind');
        $this->makeType('Posts', 'Permission', 'chrome_reader_mode');

        $this->makeType('Documentation', 'Post', 'chrome_reader_mode');
        $this->makeType('Announcements', 'Post', 'chrome_reader_mode');
        $this->makeType('Sprint', 'Task', 'directions_run');
        $this->makeType('Task', 'Task', 'rowing');
        $this->makeType('Team', 'Task', 'group');
        $this->makeType('Project', 'Task', 'timeline');
    }

    private function makeType($name, $model, $icon)
    {
        DB::table('types')->insert([
            'name' => $name,
            'slug' => str_slug($name),
            'icon' => $icon,
            'model' => $model,
            'company_id' => $this->companyId
        ]);
    }

    private function makePermission($mode, $type)
    {
        return DB::table('permissions')->insert([
            'user_id' => $this->user->id,
            'permission_mode_id' => $mode,
            'type_id' => $type,
            'company_id' => $this->companyId
        ]);
    }

    private function setupPermissionModes(){
        DB::table('permission_modes')->insert([
            'name' => 'create',
            'company_id' => $this->companyId,
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'read',
            'company_id' => $this->companyId,
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'update',
            'company_id' => $this->companyId,
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'delete',
            'company_id' => $this->companyId,
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'manage',
            'company_id' => $this->companyId,
        ]);

        DB::table('permission_modes')->insert([
            'name' => 'assign',
            'company_id' => $this->companyId,
        ]);
    }

}
