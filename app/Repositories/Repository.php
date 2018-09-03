<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
class Repository {

    public function __construct(Model $model, $arg){
        $this->model = $model;
        $this->arg = $arg;
    }

    public function findById($id){
        return $this->model::find($id);
    }

    public function getSpecifiedModel(){
        if(!isset($this->arg['id'])){
            return "Sorry... No model id was given in the arg array...";
        }
        return $this->findById($this->arg['id']);
    }

}