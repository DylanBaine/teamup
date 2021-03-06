<?php
namespace App\timatik\Repositories;

use App\Models\Type;

class TypesRepository
{
    public function __construct()
    {

    }

    public function get($model)
    {
        return company()->types()->where('model', $model)->get();
    }

    public function post()
    {
        return $this->get('Post');
    }

    public function file()
    {
        return $this->get('File');
    }

    public function task()
    {
        return $this->get('Task');
    }
}
