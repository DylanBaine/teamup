<?php

namespace App\Http\Controllers;
use App\Reports;
use Illuminate\Http\Request;
use App\Reports\Report;
class ReportController extends Controller
{
    public function show($report){
        $arg = request()->query();
        foreach(get_declared_classes() as $class){
            if(is_subclass_of($class, 'App\Reports\Report') && "App\Reports\\$report" == $class){
                return (new $class($arg))->getData();
            }
        }
        return "Report not found.";
    }
}
