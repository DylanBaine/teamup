<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class GenerateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

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
        
        $class = $this->argument('name');

        Storage::disk('repositories')->put($class.'.php', $this->repositoryBoilerPlate($class));
    }

    private function repositoryBoilerPlate($class){
        return
"<?php
namespace App\Repositories;

class $class extends Repository{

}  
";

    }
}
