<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\TEAMUP\Repositories\TypesRepository as Repo;
use Illuminate\Http\Request;

class TypeController extends Controller
{

    protected $types, $repo;
    public function __construct()
    {
        $this->repo = new Repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = \Request::get('model');
        if ($model == null) {
            $types = company()->types()->get();
        } else {
            $types = $this->repo->get($model);
        }
        return $types;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = $request->slug ? $request->slug : str_plural(str_slug($request->name));
        Type::create([
            'compay_id' => company('id'),
            'name' => $request->name,
            'slug' => $slug,
            'model' => $request->model,
            'icon' => $request->icon ? $request->icon : 'file_copy',
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $type = $this->types->where('slug', $slug)->first();
        $model = $type->model;
        return view('types.show', compact('type', 'model'));
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
        $this->types->find($id)->update([
            'name' => $request->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Type::where('id', $id)->delete($id);
    }
}
