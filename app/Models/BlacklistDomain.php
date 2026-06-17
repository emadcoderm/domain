<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistDomain extends Model
{
    protected $table = 'blacklist_domains';

    protected $fillable = ['zone_id', 'name', 'reason', 'enabled'];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function zone()
    {
        return $this->belongsTo('DomainProvider\Models\Zone', 'zone_id', 'id');
    }
}
