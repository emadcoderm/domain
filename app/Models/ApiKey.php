<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = 'api_keys';

    protected $fillable = ['user_id', 'cf_id', 'api_key', 'email', 'enabled', 'access_count', 'reseted_at'];

    protected $dates = [
        'reseted_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('DomainProvider\Models\User', 'user_id', 'id');
    }

    public function zones()
    {
        return $this->hasMany('DomainProvider\Models\Zone', 'api_key_id', 'id');
    }
}
