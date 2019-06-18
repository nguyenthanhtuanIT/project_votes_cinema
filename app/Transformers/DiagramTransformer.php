<?php

namespace App\Transformers;

use App\Models\Diagram;

/**
 * Class DiagramTransformer.
 *
 * @package namespace App\Transformers;
 */
class DiagramTransformer extends \App\Transformers\BaseTransformer
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
            'room' => $model->getRoom(),
        ];
    }
}
