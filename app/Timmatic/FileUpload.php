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
        return $this->fileName . '.' . $this->file->getClientOriginalExtension();
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
        $this->fileSlug = date('m-d-y-h-i-s') . '-' . $this->hashName . '.' . $this->file->getClientOriginalExtension();
    }

    public function getFileTypeName(){
        return (new FileExtensionTranslator($this->getFileMimeType(), $this->file->getClientOriginalExtension()))->getTypeName();
    }

    public function getFileMimeType()
    {
        return str_plural(ucwords(explode('/', $this->file->getMimeType())[0]));
    }
}
