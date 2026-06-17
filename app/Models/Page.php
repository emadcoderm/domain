<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'content', 'key', 'enabled'];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
