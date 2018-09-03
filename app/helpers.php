<?php
$files = glob(__DIR__.'\Reports\*.php');
if ($files === false) {
    throw new RuntimeException("Failed to glob for function files");
}
foreach ($files as $file) {
    require_once $file;
}


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
    return "TEAMUP\Repositories\$class";
}
