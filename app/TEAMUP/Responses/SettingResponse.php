<?php
namespace App\TEAMUP\Responses;

use App\TEAMUP\BLL\TaskLogic;
use Exception;
use Illuminate\Contracts\Support\Responsable;

class SettingResponse implements Responsable
{
    use TaskLogic;

    public function toResponse($request, $id = null)
    {
        $this->model = \Request::get('model');
        $this->modelId = \Request::get('id');
        $this->action = \Request::get('action');
        return $this->callUserFunction($request);
    }

    private function callUserFunction($request)
    {
        $method = camel_case($this->action);
        $arg = request()->query('arg') ? request()->query('arg') : null;
        if (method_exists($this, camel_case($this->action))) {
            return call_user_func([$this, $method], [$arg]);
        }
        throw new Exception('I\'m sorry... This isn\'t a valid method...');
    }
}
