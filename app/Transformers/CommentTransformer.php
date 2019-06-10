<?php

namespace App\Transformers;

use App\Models\Comment;

/**
 * Class CommentTransformer.
 *
 * @package namespace App\Transformers;
 */
class CommentTransformer extends \App\Transformers\BaseTransformer
{
    /**
     * Array attribute doesn't parse.
     */
    public $ignoreAttributes = [];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [];
}
