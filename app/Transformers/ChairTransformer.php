<?php

namespace App\Transformers;

use App\Models\Chair;

/**
 * Class ChairTransformer.
 *
 * @package namespace App\Transformers;
 */
class ChairTransformer extends App\Transformers\BaseTransformer
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
