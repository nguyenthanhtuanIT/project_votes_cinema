<?php

namespace App\Transformers;

use App\Models\Cinema;

/**
 * Class CinemaTransformer.
 *
 * @package namespace App\Transformers;
 */
class CinemaTransformer extends BaseTransformer
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

    public function customAttributes($model): array
    {
        return [

        ];
    }
}
