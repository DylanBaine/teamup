<?php

namespace App\Http\Controllers;

use App\Models\Edit;

class EditController extends Controller
{

    public $edits;

    public function __construct()
    {
        $this->edits = Edit::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->edits;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edites->find($id);
    }

}
