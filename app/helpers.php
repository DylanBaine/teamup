<?php
function company($prop = null)
{
    $company = App\Models\Company::where('id', user('company_id'))->first();
    if ($prop !== null) {
        return $company[$prop];
    }
    return $company;
}

function carbon_days_between($start, $end){
    $datesBetween = [];
    for($date = $start; $date->lte($end); $date->addDay()){
        $datesBetween[] = $date->toDateString();
    }
    return $datesBetween;
}

function weekNumberInMonth($year = null, $month =null, $day = null) {
    $year = $year == null ? (int)date('Y'):$year;
    $month = $month == null ? (int)date('m'):$month;
    $day = $day == null ? (int)date('d'):$day;
    return ceil(($day + date("w",mktime(0,0,0,$month,1,$year)))/7);   
   }

function manifest($string, $br = false){
    $br ? $string .= "\n---------------------------------------" : '';
    echo "$string\n";
    \Log::info("$string\r\n");
}

function permission_mode($name){
    return company()->permissionModes()->where('name', $name)->first();
}

function type($name){
    return company()->types()->where('name', $name)->first();
}

function user($prop = null)
{
    if ($prop != null) {
        return Auth::user()[$prop];
    }
    return Auth::user();
}

function repository($class)
{
    return "timatik\Repositories\$class";
}

function carbon_format($string){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $string)->toDateTimeString();
}

function plain_object($items){
    $obj = new stdClass;
    foreach($items as $key => $value){
        $obj->$key = $value;
    }
    return $obj;
}
