<?php
namespace App\TEAMUP\BLL;

use App\Models\Setting;
use App\Models\Subscription;

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

    function removeUserFromColumn($setting)
    {
        $sub = Subscription::where('id', $setting)->first();
        $sub->delete();
    }

    function subscribeUserToTask()
    {
        Subscription::create(request()->all());
    }

}
