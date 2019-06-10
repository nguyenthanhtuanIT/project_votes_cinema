<?php

namespace App\Models;

/**
 * Class Comment.
 *
 * @package namespace App\Models;
 */
class Comment extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'blog_id', 'content'];

}
