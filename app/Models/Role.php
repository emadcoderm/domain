<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name', 'permissions'];

    public function users()
    {
        return $this->hasMany('DomainProvider\Models\User', 'role_id', 'id');
    }
}
