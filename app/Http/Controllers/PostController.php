<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\TEAMUP\UpdatePost;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $files, $updatePost;

    public function __construct()
    {
        $this->updatePost = new UpdatePost;
        $this->posts = Post::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->posts->create([
            'name' => $request->name,
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'type_id'->$request->type,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->posts->find($id);
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
        $this->updatePost($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->posts->delete($id);
    }
}
