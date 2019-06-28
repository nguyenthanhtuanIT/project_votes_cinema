<?php

namespace App\Models;

/**
 * Class Blog.
 *
 * @package namespace App\Models;
 */
class Blog extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_blog', 'img', 'description', 'content', 'user_id'];

}
