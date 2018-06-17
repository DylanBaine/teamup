<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Type;
use App\TEAMUP\FileUpload;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    protected $files, $uploader;

    public function __construct(Request $request)
    {
        $this->uploader = new FileUpload($request);
        $this->files = File::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { /*
    $fileTypes = Type::where('model', 'File')->with(['files' => function ($files) {
    $files->where('user_id', Auth::user()->id);
    }])->get();
    return view('files.index', compact('fileTypes')); */
        return File::get();
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
            'name' => $uploader->getFileName(),
            'slug' => $uploader->getFileSlug(),
            'hash_name' => $uploader->getFileHashName(),
        ]);
        Type::firstOrCreate([
            'name' => $uploader->getFileMimeType(),
            'slug' => str_slug($uploader->getFileMimeType()),
            'icon' => 'attach_file',
            'model' => 'File',
        ])->files()->save($file);
        return $file->slug;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->files->find($id);
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
        $file = $this->files->find($id);
        Storage::disk('public')->delete('files/' . $file->hash_name);
        $file->delete();
        return redirect()->back();
    }
}
