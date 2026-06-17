<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class UserDomain extends Model
{
    protected $table = 'user_domains';

    protected $fillable = ['user_id', 'zone_id', 'name', 'enabled', 'expired_at'];

    protected $dates = [
        'expired_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function getCompleteDomainNameAttribute()
    {
        return $this->name . '.' . $this->zone->name;
    }

    public function zone()
    {
        return $this->belongsTo('DomainProvider\Models\Zone', 'zone_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('DomainProvider\Models\User', 'user_id', 'id');
    }

    public function dnsRecords()
    {
        return $this->hasMany('DomainProvider\Models\DnsRecord', 'user_domain_id', 'id');
    }
}
