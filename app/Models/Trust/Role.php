<?php

namespace App\Models\Trust;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    const SUPER_ADMIN = 'super_admin';
    const MEMBER = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return array List roles
     */
    public static function roles()
    {
        return [self::SUPER_ADMIN, self::MEMBER];
    }
}
