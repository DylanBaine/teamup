<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $with = ['type', 'mode'];
    protected $fillable = ['mode'];

    public function mode()
    {
        return $this->belongsTo(PermissionMode::class, 'permission_mode_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

}
