<?php

namespace App\Http\Controllers;
use App\Reports;
use Illuminate\Http\Request;
use App\Reports\Report;
class ReportController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $collection = [];
        foreach(get_declared_classes() as $class){
            if(is_subclass_of($class, 'App\Reports\Report')){
                $collection[] = (new $class)->getName();
            }
        }
        return $collection;
    }

    public function show($report){
        $arg = request()->query();
        foreach(get_declared_classes() as $class){
            if(is_subclass_of($class, 'App\Reports\Report') && "App\Reports\\$report" == $class){
                return (new $class($arg))->getData();
            }
        }
        abort("Report not found.");
    }
}
