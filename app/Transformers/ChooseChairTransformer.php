<?php

namespace App\Transformers;

use App\Models\ChooseChair;

/**
 * Class ChooseChairTransformer.
 *
 * @package namespace App\Transformers;
 */
class ChooseChairTransformer extends App\Transformers\BaseTransformer
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
