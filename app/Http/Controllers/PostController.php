<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Type;
use App\TEAMUP\Repositories\TypesRepository;
use App\TEAMUP\UpdatePost;
use Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $files, $updatePost;

    public function __construct()
    {
        $this->typeRepo = new TypesRepository;
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
        return Post::where('site_id', null)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Auth::user()->posts()->create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'content' => $request->content,
            'site_id' => $request->site_id,
        ]);
        if ($request->type_id) {
            $type = Type::findOrFail($request->type_id);
        } else {
            $type = Type::firstOrCreate([
                'name' => $request->type_name,
                'slug' => str_slug($request->type_name),
                'icon' => 'file_copy',
                'model' => $request->model,
            ]);
        }
        $type->posts()->save($post);
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
        Post::find($id)->update($request->all());
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
