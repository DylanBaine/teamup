<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
class Repository {

    public function __construct($model, $arg){
        $this->model = $model;
        $this->arg = $arg;
    }

    public function findById($id){
        return $this->model::find($id);
    }

    public function getSpecifiedModel(){
        if(!isset($this->arg['id'])){
            abort("Sorry... No model id was given in the arg array...", 500);
        }
        return $this->findById($this->arg['id']);
    }

}