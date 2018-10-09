<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;
use Storage;
use Log;

class CleanFilesDirectory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Match the file storage directory with the database and remove unwanted files.';

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
        $this->log("Cleaning files directory....");
        $dbFiles = File::get()->pluck('hash_name')->toArray();
        $dirFiles = Storage::allFiles('public/files');

        foreach($dirFiles as $file){
            $dirFileHash = explode('/', $file)[2];
            if(!in_array($dirFileHash, $dbFiles)){
                $this->log("Deleting $file");
                Storage::delete($file);
            }
        }
        $this->log("Files directory job finnished");
    }

    function log($string){
        echo "$string\r\n";
        manifest("$string\r\n");
    }

}
