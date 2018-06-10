<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\TEAMUP\Responses\SettingResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->actions = new SettingResponse;
        $this->settings = Setting::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->actions->toResponse($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->settings->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $s = Setting::find($id);
        $s->name = $request->name;
        $s->value = $request->value;
        $s->position = $request->position;
        $s->save();
        //return $this->actions->toResponse($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->setting->find($id)->delete();
        return response()->json(true);
    }
}
