<?php

namespace App\Models;

/**
 * Class Image.
 *
 * @package namespace App\Models;
 */
class Image extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['filename', 'object_id', 'object_type', 'name', 'pathname'];

}
