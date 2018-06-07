<?php
namespace App\TEAMUP\Responses;

use App\TEAMUP\BLL\TaskLogic;
use App\TEAMUP\Contracts\ResponseContract;
use Exception;

class SettingResponse implements ResponseContract
{
    use TaskLogic;

    public function respond($request, $id = null)
    {
        $this->model = \Request::get('model');
        $this->modelId = \Request::get('id');
        $this->action = \Request::get('action');
        if ($id !== null) {
            return $this->update($request, $id);
        }
        return $this->create($request);
    }

    public function update($request, $id)
    {

    }

    public function create($request)
    {
        return $this->callUserFunction($request);
    }

    private function callUserFunction($request)
    {
        if (method_exists($this, camel_case($this->action))) {
            return call_user_func([$this, camel_case($this->action)], [$request]);
        }
        throw new Exception('I\'m sorry... This isn\'t a valid method...');
    }

}
