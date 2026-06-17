<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class DnsRecord extends Model
{
    protected $table = 'dns_records';

    protected $fillable = [
        'zone_id', 'user_domain_id', 'cf_id', 'type', 'name', 'content',
        'proxiable', 'proxied', 'ttl', 'locked', 'priority', 'data'
    ];

    protected $casts = [
        'proxiable' => 'boolean',
        'proxied' => 'boolean',
        'locked' => 'boolean',
    ];

    private $formEdit;

    public function setFormEdit($dnsFormEdit)
    {
        $this->formEdit = $dnsFormEdit;

        return $this;
    }

    public function getFormEdit()
    {
        return $this->formEdit;
    }

    public function zone()
    {
        return $this->belongsTo('DomainProvider\Models\Zone', 'zone_id', 'id');
    }

    public function userDomain()
    {
        return $this->belongsTo('DomainProvider\Models\UserDomain', 'user_domain_id', 'id');
    }
}
