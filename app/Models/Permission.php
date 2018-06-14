<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $with = ['type', 'mode', 'user'];
    protected $fillable = ['permission_mode_id', 'user_id', 'type_id'];

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
