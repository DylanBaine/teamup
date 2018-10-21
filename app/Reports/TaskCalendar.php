<?php
namespace App\Reports;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskCalendar {
    public function __construct(){
    }

    public function show($month, Collection $taskQuery){
        $this->tasks = $taskQuery;
        $start = $this->dayOfMonth('first', $month);
        $end = $this->dayOfMonth('last', $month);
        $endMonthBefore = $this->dayOfMonth('last', $start->subMonth()->format('F'));
        $start->addMonth();
        $daysOfMonth = carbon_days_between($start, $end);
        $days = collect([]);
        $firstWeekOffset = collect([]);
        $count = 1;
        $lastDayOfMonthBefore = carbon_day_of_month('last', $start->subMonth()->subMonth()->format('F'));
        $start->addMonth();
        while($count < $start->format('w') + 1){
            $firstWeekOffset->push(plain_object([
                'date' => $lastDayOfMonthBefore->format('d'),
                'day_string' => $lastDayOfMonthBefore->format('l'),
                'tasks' => [],
                'month' => Carbon::parse($lastDayOfMonthBefore)->format('F')
            ]));
            $lastDayOfMonthBefore->subDay();
            $count++;
        }
        foreach($daysOfMonth as $day){
            $tasks = $this->tasks->where('start_date','<=', $day)->where('end_date', '>=', $day)->flatten(1)->toArray();
            $days->push(plain_object([
                'tasks' => $tasks,
                'date' => Carbon::parse($day)->format('d'),
                'day_string' => Carbon::parse($day)->format('l'),
                'date_string' => Carbon::parse($day)->format('l, F jS, Y'),
                'month' => Carbon::parse($day)->format('F'),
                'is_today' => $day == Carbon::now()->toDateString() 
            ]));
        }

        $days = collect(array_merge($firstWeekOffset->reverse()->toArray(), $days->toArray()));

        $dayStrings = [
            'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
        ];

        $rows = collect([]);
            
        foreach($dayStrings as $ds){
            $d =$days->where('day_string', $ds)->unique('date');
            $rows->push(plain_object([
                'day' => $ds,
                'dates' => $d
            ]));
        }
        return plain_object([
            'month' => $month,
            'rows' => $rows
        ]);
    }

    public function dayOfMonth($day, $month = null){
        $month = $month??date('F');
        return Carbon::parse($day.' day of '. " $month ".date('Y'));
    }

}        
