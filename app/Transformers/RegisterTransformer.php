<?php

namespace App\Transformers;

use App\Models\Register;

/**
 * Class RegisterTransformer.
 *
 * @package namespace App\Transformers;
 */
class RegisterTransformer extends BaseTransformer {
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
