<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = ['name', 'email', 'message', 'seen'];

    protected $casts = [
        'seen' => 'boolean',
    ];
}
