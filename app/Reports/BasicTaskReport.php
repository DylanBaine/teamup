<?php
namespace App\Reports;
use App\Repositories\BasicTaskReportRepository;
use App\Models\Task;
use Carbon\Carbon;
class BasicTaskReport extends Report {

    public function __construct($arg){
        $this->repository = new BasicTaskReportRepository(new Task, $arg);
    }

    protected function format(){
        return[
            'percent' => $this->percents(),
            'days' => $this->days()
        ];
    }

    private function percents(){
        return [
            ['Column', 'Percent'],
            ['in progress' , $this->repository->percentOfTimeIn('In Progress')],
            ['in backlog' , $this->repository->percentOfTimeIn('Back Log')],
            ['in finished' , $this->repository->percentOfTimeIn('Finished')],
        ];
    }

    private function days(){
        return [
            'existed' => $this->repository->getSpecifiedModel()->created_at->diffInDays(Carbon::now())/$this->repository->getSpecifiedModel()->created_at->diffInSeconds(Carbon::now())*100,
            'in_backlog' => $this->repository->daysInColumn('Back Log'),
            'in_current_column' => $this->repository->daysInCurrentColumn()
        ];
    }

}        
