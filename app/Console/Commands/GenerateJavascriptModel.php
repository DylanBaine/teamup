<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class GenerateJavascriptModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:js:model {name}';

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
        Storage::disk('js_models')->put($class.'.js', $this->modelBoilerPlate($class));
    }

    private function modelBoilerPlate($class){
        $modelSlug = str_plural(str_slug($class));
        return
"import Model from '../library/Model';
class $class extends Model {
    constructor(instance, store) {
        super({
            post: '$modelSlug',
            get: '$modelSlug'
        }, { instance, store });
        this.root = instance.\$root;
    }
}
export default $class;
";
    }
}
