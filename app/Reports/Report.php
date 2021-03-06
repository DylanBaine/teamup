<?php
namespace App\Reports;

abstract class Report {

    private $data;
    protected $repository;

    protected abstract function format();

    public function getData(){
        if(!isset($this->data)){
            return $this->format();
        }
        return $this->data;
    }

    protected function setData($data){
        $this->data = $data;
    }
    
    public function getName() {
        $path = explode('\\', get_called_class());
        return array_pop($path);
    }

}