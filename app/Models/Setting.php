<?php

namespace DomainProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'page_title', 'lead_text', 'middle_title', 'middle_body', 'domain_min_chars',
        'domain_max_chars', 'domain_registration_year', 'footer_left_title', 'footer_left_body', 'footer_right_title', 'footer_right_body',
        'footer_social_title', 'footer_social_facebook', 'footer_social_twitter', 'footer_social_googleplus',
        'footer_social_pinterest', 'footer_social_linkedin', 'footer_social_instagram', 'footer_social_youtube',
        'captcha_on_register', 'captcha_on_login', 'google_analytics',
    ];

    protected $casts = [
        'captcha_on_register' => 'boolean',
        'captcha_on_login' => 'boolean',
    ];
}
