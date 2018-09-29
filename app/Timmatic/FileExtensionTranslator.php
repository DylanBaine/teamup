<?php
namespace App\Timmatic;

class FileExtensionTranslator {

    private $typeName;
    private $fileTypes = [

    ];
    public function __construct($mimeType, $extension){
        $this->mimeType = $mimeType;
        $this->setTypeNameFromExtension($extension);
    }

    public function getTypeName(){
        return ucwords(str_singular($this->typeName));
    }

    private function setTypeNameFromExtension($extension){
        switch($this->mimeType){
            case 'image' :
                $fn = 'Image';
                break;
            default :
                $fn = $this->filterApplication($extension);
        }
        $this->typeName = $fn;
    }

    private function filterApplication($extension){
        switch($extension){
            /* excel */
            case 'xlsx' :
                $fn = 'Excel Sheet';
                break;
            case 'xls' :
                $fn = 'Excel Sheet';
                break;
            case 'xltx' :
                $fn = 'Excel Sheet';
                break;
            case 'xltm' :
                $fn = 'Excel Sheet';
                break;
                /* word */
            case 'docx' :
                $fn = 'Word Document';
                break;
            case 'doc' :
                $fn = 'Word Document';
                break;
            case 'docm' :
                $fn = 'Word Document';
                break;
            case 'docb' :
                $fn = 'Word Document';
                break;
                /* power point */
            case 'ppt' :
                $fn = 'Power Point';
                break;
            case 'pptx' :
                $fn = 'Power Point';
                break;
            case 'potx' :
                $fn = 'Power Point';
                break;
            case 'potm' :
                $fn = 'Power Point';
                break;
            case 'ppam' :
                $fn = 'Power Point';
                break;
            case 'ppsx' :
                $fn = 'Power Point';
                break;
            case 'ppsm' :
                $fn = 'Power Point';
                break;
            case 'sldx' :
                $fn = 'Power Point';
                break;
            case 'sldm' :
                $fn = 'Power Point';
                break;
                /* etc */
            case 'exe' :
                $fn = 'Executable File';
                break;
            case 'sh' :
                $fn = 'Shell Script';
                break;
            case 'ods' :
                $fn = 'OpenDocument';
                break;
            case 'js' :
                $fn = 'Java Script';
                break;
            default :
                $fn = $extension;
            }
            return $fn;
    }

}