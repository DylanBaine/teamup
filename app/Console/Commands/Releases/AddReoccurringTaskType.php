<?php

namespace App\Console\Commands\Releases;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\User;

class AddReoccurringTaskType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'release:ReoccurringTaskType';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the new Reoccurring Task type.';

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
            $company->types()->create([
                'name' => 'Reoccurring',
                'slug' => 'reoccurring-task',
                'model' => 'Task',
                'icon' => 'rowing'
            ]);
        }
    }
}
