<?php
namespace App\Repositories;
use Carbon\Carbon;
use App\Models\Task;

class BasicTaskReportRepository extends Repository{


    public function daysInCurrentColumn(){
        return $this->daysInColumn($this->getSpecifiedModel()->column->value);
    }

    public function secondsInColumn($columnName){
        $changes = $this->getSpecifiedModel()->changes()->whereHas('column', function($column) use ($columnName){
            $column->where('value', $columnName);
        });
        $collection = [];
        foreach($changes->get() as $change){
            $collection[] = ($change->duration_in_seconds);
        }
        $sum = array_sum($collection);
        if($columnName == $this->getSpecifiedModel()->column->value){
            $sum+=$changes->orderBy('id', 'desc')->first()->created_at->diffInSeconds(Carbon::now());
        }
        return $sum;
    }

    public function percentOfTimeIn($column){
        return round( 
        (
            (
                $this->secondsInColumn($column) / ($this->getSpecifiedModel()->created_at->diffInSeconds(Carbon::now()))
            ) * 100
        ), 2 );
    }

    public function daysInColumn($column){
        return round($this->secondsInColumn($column) / 86400, 1);
    }

    public function changesBetweenDates($start, $end){
        return $this->getSpecifiedModel()->changes()->whereBetween('created_at', [$start, $end])->get();
    }

}  
