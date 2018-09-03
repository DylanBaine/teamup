<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:report {name}';

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

        Storage::disk('reports')->put($class.'.php', $this->reportBoilerPlate($class));

        $this->call('make:repository', [
            'name' => $class.'Repository'
        ]);

        echo "Report scaffolding for $class completed.";
    }

    private function reportBoilerPlate($class){
        $repoClass = $class.'Repository';
        return 
"<?php
namespace App\Reports;
use App\Repositories\\$repoClass;
class $class extends Report {
    public function __construct(\$arg){
            /**
             * @param Model \$model the model that the repository is responsable for
             * @param Array \$arg array of arguments used in the request
             */
        \$this->repository = new $repoClass(\$model, \$arg);
    }

    public function format(){
        return [];
    }

}        
";

    }
}
