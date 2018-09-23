<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function toArray(){
        $data = parent::toArray();
        $data['custom_fields'] = json_decode($this->custom_fields);
        return $data;
    }
    protected $fillable = [
        'name', 'email', 'custom_fields', 'type_id'
    ];
}
