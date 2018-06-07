<?php
namespace App\TEAMUP\Contracts;

interface ResponseContract
{
    function create($request);
    function update($request, $id);
}
