<?php

namespace App\Transformers;

use App\Models\Films;

/**
 * Class FilmsTransformer.
 *
 * @package namespace App\Transformers;
 */
class FilmsTransformer extends BaseTransformer {
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

		return ['genre' => $model->getTypeFilms(),
		];

	}
}
