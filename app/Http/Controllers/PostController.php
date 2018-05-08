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
        $this->posts = Post::get();
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
        Post::create([
            'name' => $request->name,
            'content' => $request->content,
            'user_id' => \Auth::user()->id,
            'type_id' => $request->type_id,
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->posts->find($id);
        return view('posts.show', compact('post'));
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
        $this->posts->find($id)->delete();
        return redirect()->back();
    }
}
