<?php

namespace App\Transformers;

use App\User;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['image'];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = ['image'];

    /**
     * Transform the custom field entity.
     *
     * @return array
     */
    public function customAttributes($model): array
    {
        return [
            'roles' => $model->getRoles(),
            'avatar' => $model->image ? Storage::url('thumbnails/' . $model->image->filename) : null,
            'tokens' => $model->tokens,
        ];
    }

    /**
     * Include owners
     *
     * @param  Illuminate\Database\Eloquent\Model $salon
     */
    public function includeImage(User $user)
    {
        $image = $user->image;

        if (!$image) {
            return;
        }

        return $this->item($image, new ImageTransformer, 'Image');
    }
}
