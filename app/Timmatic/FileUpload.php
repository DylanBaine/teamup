<?php
namespace App\Timmatic;

use Illuminate\Http\Request;

class FileUpload
{
    private $file, $fileName, $fileSlug, $mimeType, $hashName;

    public function __construct(Request $request)
    {
        $this->file = $request->file('file');
        $this->fileName = $request->file_name;
        $this->hashName = str_random(10);
    }
    public function storeFile()
    {
        $this->setFileSlug();
        $this->file->storeAs('files', $this->fileSlug, 'public');
    }

    public function getFileName()
    {
        $extension = $this->file->getClientOriginalExtension();
        return $this->fileName . '.' . $extension;
    }

    public function getFileSlug()
    {
        return url('storage/files/' . $this->fileSlug);
    }
    public function getFileHashName()
    {
        return $this->fileSlug;
    }
    private function setFileSlug()
    {
        $e = $this->file->getClientOriginalExtension();
        if($e == 'php'){
            $extension = "_".$e;
        }else{
            $extension = ".".$e;
        }
        $this->fileSlug = date('m-d-y-h-i-s') . '-' . $this->hashName . $extension;
    }

    public function getFileTypeName(){
        return (new FileExtensionTranslator($this->getFileMimeType(), $this->file->getClientOriginalExtension()))->getTypeName();
    }

    public function getFileMimeType()
    {
        return explode('/',$this->file->getMimeType())[0];
    }
}
