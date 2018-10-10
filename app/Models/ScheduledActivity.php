<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ScheduledActivity extends Model
{
    protected $fillable = [
        'type', 'time', 'day', 'week', 'schedulable_type', 'schedulable_id'
    ];

    public function shouldRunNow(){
        $today = date('l');
        $week = weekNumberInMonth();
        $time = date('G');
        $thisTime = explode(':', $this->time)[0];
        echo "Time:\n";
        echo "now: $time, schedule: $thisTime\n";
        echo "Week:\n";
        echo "now: $week, schedule: $this->week\n";
        echo "Day:\n";
        echo "now: $today, schedule: $this->day\n";
        switch ($this->type) {
            case "Daily":
                return $time == $thisTime;
            case "Weekly":
                return $today == $this->day && $time == $thisTime;
            case "Monthly":
                return $week == $this->week && $today == $this->day && $time == $thisTime;
        }
    }
}
