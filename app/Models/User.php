<?php

namespace DomainProvider\Models;

use Cache;
use DomainProvider\Helpers\Constants;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['full_name', 'email', 'password', 'role_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function role()
    {
        return $this->belongsTo('DomainProvider\Models\Role', 'role_id', 'id');
    }

    public function apiKeys()
    {
        return $this->hasMany('DomainProvider\Models\ApiKey', 'user_id', 'id');
    }

    public function userDomains()
    {
        return $this->hasMany('DomainProvider\Models\UserDomain', 'user_id', 'id');
    }

    public function isAdmin()
    {
        return Constants::ROLE_SUPER_ADMIN === $this->role->name;
    }
}
