<?php

namespace App\Transformers;

use App\Models\Random;

/**
 * Class RandomTransformer.
 *
 * @package namespace App\Transformers;
 */
class RandomTransformer extends \App\Transformers\BaseTransformer
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
