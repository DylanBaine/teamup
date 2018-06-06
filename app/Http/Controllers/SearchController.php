<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(){
        //$this->middleware('permissions');
    }
    public function __invoke()
    {
        $model = '\App\Models\\' . \Request::get('model');
        $param = \Request::get('param');
        $value = \Request::get('value');
        $result = $model::where($param, 'like', '%'.$value.'%')->get();
        return response()->json($result);
    }
}
