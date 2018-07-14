<?php

namespace App\Policies\Company;

use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show($model)
    {
        return company('id') === $model->company_id;
    }
}
