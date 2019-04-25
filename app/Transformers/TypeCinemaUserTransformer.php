<?php

namespace App\Transformers;

use App\Models\TypeCinemaUser;

/**
 * Class TypeCinemaUserTransformer.
 *
 * @package namespace App\Transformers;
 */
class TypeCinemaUserTransformer extends BaseTransformer {
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
