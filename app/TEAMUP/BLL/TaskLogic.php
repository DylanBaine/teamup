<?php
namespace App\TEAMUP\BLL;

use App\Models\Setting;

trait TaskLogic
{

    function addColumn()
    {
        Setting::create([
            'name' => 'column',
            'value' => request('value'),
            'position' => request('position'),
            'settable_id' => request()->query('id'),
            'settable_type' => 'App\Models\\' . request()->query('model'),
        ]);
    }

    function removeColumn($id)
    {
        $setting = Setting::where('id', $id)->first();
        $setting->delete();
    }

    function subscribeUserToColumn()
    {
    }

    function subscribeUserToTask()
    {
    }

}
