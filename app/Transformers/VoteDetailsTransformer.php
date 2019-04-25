<?php

namespace App\Transformers;

use App\Models\VoteDetails;

/**
 * Class VoteDetailsTransformer.
 *
 * @package namespace App\Transformers;
 */
class VoteDetailsTransformer extends App\Transformers\BaseTransformer
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
