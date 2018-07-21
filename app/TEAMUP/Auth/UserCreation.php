<?php
namespace App\TEAMUP\Auth;

use App\Models\Company;
use App\Models\User;
use Auth;
use App\Models\PermissionMode;
use DB;
class UserCreation
{

    private $create = [
        'Posts', 'Post Types', 'Tasks', 'Task Types', 'Users', 'Permissions', 'Permission Modes',
        'Documentation', 'Announcements', 'Permission Types'
    ];
    private $read = [
        'Posts', 'Tasks', 'Users', 'Permissions',
        'Documentation', 'Announcements'
    ];
    private $update = [
        'Posts', 'Post Types', 'Tasks', 'Task Types', 'Users', 'Permissions', 'Permission Modes',
        'Documentation', 'Announcements', 'Permission Types'
    ];
    private $delete = [
        'Posts', 'Post Types', 'Tasks', 'Task Types', 'Users', 'Permissions', 'Permission Modes',
        'Documentation', 'Announcements', 'Permission Types'
    ];
    private $manage = [
        'Tasks', 'Users', 'Permissions'
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
        return $this->user->load('company');
    }

    private function createUser()
    {
        $r = $this->request;
        $userData = [
            'name' => $r->name,
            'email' => $r->email,
            'password' => bcrypt($r->password),
            'company_id' => 0,
        ];
        User::create($userData);
        $this->user = User::with('permissions')->where('email', $r->email)->first();
        Auth::login($this->user);
    }

    private function createCompany()
    {
        $r = $this->request;
        $companyData = [
            'name' => $r->companyName,
            'super_user_id' => $this->user->id,
            'plan_id' => 1,
        ];
        $company = new Company;
        $company->name = $r->companyName;
        $company->super_user_id = $this->user->id;
        $company->plan_id = 1;
        $company->save();
        $this->user->company_id = $company->id;
        $this->user->save();
        $this->companyId = $company->id;
        $this->company = $company;
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
        $this->makeType('Permission Modes', 'Permission', '');
        $this->makeType('Permission Types', 'Permission', '');
        $this->makeType('Post Types', 'Permission', '');
        $this->makeType('Permissions', 'Permission', 'supervised_user_circle');
        $this->makeType('Posts', 'Permission', 'format_align_left');
        $this->makeType('Tasks', 'Permission', 'rowing');
        $this->makeType('Task Types', 'Permission', 'rowing');
        $this->makeType('Groups', 'Permission', 'group');
        $this->makeType('Documentation', 'Post', 'chrome_reader_mode');
        $this->makeType('Announcements', 'Post', 'chrome_reader_mode');
        $this->makeType('Sprint', 'Task', 'directions_run');
        $this->makeType('Task', 'Task', 'rowing');
        $this->makeType('Team', 'Task', 'group');
        $this->makeType('Users', 'Permission', 'person');
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
