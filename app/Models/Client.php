<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    public function contacts(){
        return $this->morphToMany(Contact::class, 'contactables');
    }
}
