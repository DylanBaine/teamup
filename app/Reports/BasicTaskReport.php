<?php
namespace App\Reports;
use App\Repositories\BasicTaskReportRepository;
use App\Models\Task;
use Carbon\Carbon;
class BasicTaskReport extends Report {

    public static $name = "Task Report";
    public function __construct($arg = null){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new BasicTaskReportRepository(new Task, $arg);
    }

    protected function format(){
        if(
            count($this->repository->getSpecifiedModel()->columns) 
            || $this->repository->getSpecifiedModel()->column_id != null
        ){
            return[
                'percent' => $this->percents(),
                'days' => $this->days(),
                'changes' => $this->repository->getSpecifiedModel()->changes
            ];
        }
    }

    private function percents(){
        $columns = collect([
            ['Column', 'Percent']
        ]);
        foreach($this->repository->getSpecifiedModel()->parent->columns as $column){
            $columns->push([$column->value, $this->repository->percentOfTimeIn($column->value)]);
        }
        return $columns; 
/*         [
            ['In Progress' , $this->repository->percentOfTimeIn('In Progress')],
            ['Back Log' , $this->repository->percentOfTimeIn('Back Log')],
            ['Finished' , $this->repository->percentOfTimeIn('Finished')],
        ]; */
    }

    private function days(){
        return [
            'existed' => $this->repository->getSpecifiedModel()->created_at->diffInDays(Carbon::now())/$this->repository->getSpecifiedModel()->created_at->diffInSeconds(Carbon::now())*100,
            'in_backlog' => $this->repository->daysInColumn('Back Log'),
            'in_current_column' => $this->repository->daysInCurrentColumn()
        ];
    }


}        
