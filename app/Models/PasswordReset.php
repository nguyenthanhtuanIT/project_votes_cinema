<?php

namespace App\Models;

use Eloquent as Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'email', 'token'
    ];
}