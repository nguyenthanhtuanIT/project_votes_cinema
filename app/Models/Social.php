<?php

namespace App\Models;

/**
 * Class Social.
 *
 * @package namespace App\Models;
 */
class Social extends BaseModel
{
    const PROVIDER_FACEBOOK = 'facebook';
    const PROVIDER_GOOGLE = 'google';

    public $fillable = ['social_name', 'social_id', 'user_id'];
}
