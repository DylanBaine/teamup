<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Type;
use App\Timmatic\Repositories\TypesRepository;
use App\Timmatic\UpdatePost;
use Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $files, $updatePost;

    public function __construct()
    {
        $this->typeRepo = new TypesRepository;
        $this->updatePost = new UpdatePost;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return company()->posts()->get();
    }

    public function create($type){
        return response()->json([
            'type' => Type::where('slug', $type)->first(),
        ]);        
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
            'company_id' => company('id'),
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'content' => $request->content,
            'site_id' => $request->site_id,
        ]);
        if ($request->type_id) {
            $type = Type::findOrFail($request->type_id);
        } else {
            $type = Type::firstOrCreate([
                'company_id' => company('id'),
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
        $post = company()->posts()->find($id);
        return $post;
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
    
    public function edit($type, $id){
        return response()->json([
            'type' => Type::where('slug', $type)->first(),
            'post' => Post::find($id)
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
        Post::find($id)->delete();
    }
}
