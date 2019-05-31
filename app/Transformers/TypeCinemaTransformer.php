<?php

namespace App\Transformers;

use App\Models\TypeCinema;

/**
 * Class TypeCinemaTransformer.
 *
 * @package namespace App\Transformers;
 */
class TypeCinemaTransformer extends BaseTransformer {
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
