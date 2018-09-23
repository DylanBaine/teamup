<?php

namespace App\Console\Commands\Releases;

use Illuminate\Console\Command;
use App\Models\Company;

class Demo2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'release:demo2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(Company::get() as $company){

            if($company->types('files') == null){

                $company->types()->create([
                    'name' => 'Files',
                    'icon' => 'folder_shared',
                    'slug' => 'files',
                    'model' => 'Permission'
                ]);

                $type = $company->types('files');

                $company->permissions()->create([
                    'type_id' => $type->id,
                    'permission_mode_id' => $company->permissionModes('read')->id,
                    'user_id' => $company->superUser->id
                ]);

                $company->permissions()->create([
                    'type_id' => $type->id,
                    'permission_mode_id' => $company->permissionModes('manage')->id,
                    'user_id' => $company->superUser->id
                ]);

                $company->permissions()->create([
                    'type_id' => $type->id,
                    'permission_mode_id' => $company->permissionModes('update')->id,
                    'user_id' => $company->superUser->id
                ]);


                $company->permissions()->create([
                    'type_id' => $type->id,
                    'permission_mode_id' => $company->permissionModes('delete')->id,
                    'user_id' => $company->superUser->id
                ]);

                $company->permissions()->create([
                    'type_id' => $type->id,
                    'permission_mode_id' => $company->permissionModes('create')->id,
                    'user_id' => $company->superUser->id
                ]);

            }

        }
    }
}
