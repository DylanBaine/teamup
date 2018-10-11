<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\timatik\FileUpload;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use DB;

class FileController extends Controller
{

    protected $files, $uploader;

    public function __construct(Request $request)
    {
        $this->uploader = new FileUpload($request);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s = request()->query('search');
        if($s){
            return company()->files()->where('name', 'like', "%$s%")->orWhereHas('type', function($type) use($s){
                $type->where('name', 'like', "%$s%");
            })->get();
        }
        return response()->json([
            'files' => company()->types()->where('model', 'File')->with('files')->get(),
            'types' => company()->types()->where('model', 'File')->get(),
            'collection' => company()->files
        ]);
    }

    public function getType($slug){
        return response()->json([
            'files' => company()->files()->with('type')->whereHas('type', function($type) use ($slug){
                $type->where('slug', $slug);
            })->get(),
            'types' => company()->types()->where('model', 'File')->get()
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
        $uploader = $this->uploader;
        $uploader->storeFile();
        $file = Auth::user()->files()->create([
            'company_id' => company('id'),
            'name' => $uploader->getFileName(),
            'slug' => $uploader->getFileSlug(),
            'hash_name' => $uploader->getFileHashName(),
        ]);
        Type::firstOrCreate([
            'company_id' => company('id'),
            'name' => $uploader->getFileTypeName(),
            'slug' => str_slug($uploader->getFileTypeName()),
            'icon' => 'attach_file',
            'model' => 'File',
        ])->files()->save($file);
        return $file->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return company()->files()->find($id);
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
        $uploader = $this->uploader;
        $this->uploader->storeFile();
        $this->files->find($id)->update([
            'name' => $uploader->getFileName(),
            'slug' => $uploader->getFileSlug(),
            'hash_name' => $uploader->getFileHashName(),
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
        $file = File::find($id);
        $type = $file->type;
        Storage::disk('public')->delete('files/' . $file->hash_name);
        $file->delete();
        if($type->files()->count() < 1){
            $type->delete();
        }
        $taskPivots = DB::table('file_task')->where('file_id', $id)->delete();    
    }
}
