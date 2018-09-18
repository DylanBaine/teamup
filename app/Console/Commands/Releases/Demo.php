<?php

namespace App\Console\Commands\Releases;

use Illuminate\Console\Command;
use App\Models\Company;

class Demo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'releas:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database for version 2.';

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
            if(!$company->types()->where('slug', 'clients')->exists()){
                $company->types()->create([
                    'name' => 'Clients',
                    'slug' => 'clients',
                    'icon' => 'assignment_ind',
                    'model' => 'Permission'
                ]);
            }

            $type = $company->types()->where('slug', 'clients')->first();

            $readMode = $company->permissionModes()->where('name', 'read')->first();
            $manageMode = $company->permissionModes()->where('name', 'manage')->first();
            $readData = [
                'type_id' => $type->id,
                'permission_mode_id' => $readMode->id,
                'user_id' => $company->superUser->id
            ];
            if(!$company->permissions()->where($readData)->exists()){
                $company->permissions()->create($readData);
            };

            $manageData = [
                'type_id' => $type->id,
                'permission_mode_id' => $manageMode->id,
                'user_id' => $company->superUser->id
            ];
            if(!$company->permissions()->where($manageData)->exists()){
                $company->permissions()->create($manageData);
            }

        }
    }
}
