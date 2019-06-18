<?php

namespace App\Transformers;

use App\Models\Room;

/**
 * Class RoomTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoomTransformer extends \App\Transformers\BaseTransformer
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
            //'room' => $model->getRoom(),
        ];
    }
}
