<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File as LaravelFile;

class File extends Model
{
    //public $with = ['users', 'groups'];
    protected $fillable = ['name', 'slug', 'type', 'hash_name', 'company_id'];
    protected $with = ['type'];

    public function toArray(){
        $contents = (string)LaravelFile::get(base_path('storage/app/public/files/'.$this->hash_name));
        $data = parent::toArray();
        if(mb_detect_encoding($contents, 'UTF-8', true)){
            $data['file_contents'] = $contents;
        }
        return $data;
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }
}
