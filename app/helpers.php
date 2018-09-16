<?php
function company($prop = null)
{
    $company = App\Models\Company::where('id', user('company_id'))->first();
    if ($prop !== null) {
        return $company[$prop];
    }
    return $company;
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
    return "Timmatic\Repositories\$class";
}

function carbon_format($string){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $string)->toDateTimeString();
}
