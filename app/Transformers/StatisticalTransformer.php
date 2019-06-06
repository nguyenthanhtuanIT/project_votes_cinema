<?php

namespace App\Transformers;

use App\Models\Statistical;

/**
 * Class StatisticalTransformer.
 *
 * @package namespace App\Transformers;
 */
class StatisticalTransformer extends \App\Transformers\BaseTransformer
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
