<?php

namespace App\Transformers;

use App\Models\VoteDetails;

/**
 * Class VoteDetailsTransformer.
 *
 * @package namespace App\Transformers;
 */
class VoteDetailsTransformer extends BaseTransformer {
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
		$film = ['name_film' => $model->getFilm(), 'user_vote' => $model->getName(), 'vote_name' => $model->getVote()];
		return $film;

	}
}
