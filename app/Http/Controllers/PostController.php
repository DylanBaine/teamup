<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Type;
use App\TEAMUP\UpdatePost;
use Auth;
use Illuminate\Http\Request;
use App\TEAMUP\Repositories\TypesRepository;

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
        $posts = $this->posts;
        $types = $this->typeRepo->get('posts');
        $model = 'Post';
        return view('types.index', compact('posts', 'types', 'model'));
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
            'content' => $request->content,
        ]);
        if ($request->type_id) {
            $type = Type::findOrFail($request->type_id);
        } else {
            $type->Type::firstOrCreate([
                'name' => $request->type_name,
                'slug' => str_slug($request->type_name),
                'model' => 'Post',
            ]);
        }
        $type->posts()->save($post);
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
