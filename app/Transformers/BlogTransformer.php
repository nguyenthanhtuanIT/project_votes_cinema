<?php

namespace App\Transformers;

use App\Models\Blog;

/**
 * Class BlogTransformer.
 *
 * @package namespace App\Transformers;
 */
class BlogTransformer extends BaseTransformer {
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
