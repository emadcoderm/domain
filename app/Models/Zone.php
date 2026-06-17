<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';

    protected $fillable = ['api_key_id', 'cf_id', 'name', 'name_servers', 'status', 'paused', 'enabled'];

    protected $casts = [
        'paused' => 'boolean',
        'enabled' => 'boolean',
    ];

    public function apiKey()
    {
        return $this->belongsTo('DomainProvider\Models\ApiKey', 'api_key_id', 'id');
    }

    public function blacklistDomains()
    {
        return $this->hasMany('DomainProvider\Models\BlacklistDomain', 'zone_id', 'id');
    }

    public function userDomains()
    {
        return $this->hasMany('DomainProvider\Models\UserDomain', 'zone_id', 'id');
    }

    public function dnsRecords()
    {
        return $this->hasMany('DomainProvider\Models\DnsRecord', 'zone_id', 'id');
    }

    public function getDomainName($name)
    {
        return sprintf("%s.%s", $name, $this->name);
    }
}
