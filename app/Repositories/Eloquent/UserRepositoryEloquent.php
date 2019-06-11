<?php

namespace App\Repositories\Eloquent;

use App\Models\Image;
use App\Models\Register;
use App\Repositories\Contracts\UserRepository;
use App\Services\RoleService;
use App\User;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function presenter()
    {
        return \App\Presenters\UserPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Override method create to add owners
     * @param  array  $attributes attributes from request
     * @return object
     */
    public function create(array $attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);
        $user = parent::create(array_except($attributes, 'role'));

        // find or create role admin
        if (!empty($attributes['role'])) {
            RoleService::add($user, $attributes['role']);
        }

        return $user;
    }

    public function update(array $attributes, $id)
    {
        if (!empty($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        }
        $user = parent::update(array_except($attributes, 'role', 'photo'), $id);

        if (!empty($attributes['role'])) {
            RoleService::sync($user, $attributes['role']);
        }

        if (!empty($attributes['photo'])) {
            if ($user->image) {
                Storage::delete($user->image->pathname);
                Storage::delete('thumbnails/' . $user->image->filename);
                $user->image->delete();
            }
            Image::where('id', $attributes['photo'])->update([
                'object_id' => $user->id,
                'object_type' => User::IMAGE_TYPE,
            ]);
        }

        //$user = $user->refresh();

        return $this->find($id);
    }
    public function getListUser($vote_id)
    {
        $arr_r = array();
        $arr_r1 = array();
        $arr_r2 = array();
        $r = Register::where('vote_id', $vote_id)->get();
        foreach ($r as $val) {
            array_push($arr_r, $val->user_id);
        }
        $r1 = Register::where('vote_id', $vote_id)->where('ticket_number', '>', 1)->get();
        foreach ($r1 as $val) {
            $us = explode(',', $val->best_friend);
            for ($i = 0; $i < count($us); $i++) {
                $arr_r1[] = $us[$i];
            }
        }
        for ($i = 0; $i < count($arr_r1); $i++) {
            $k = (int) $arr_r1[$i];
            $arr_r2[] = $k;
        }
        $arr = array_merge($arr_r, $arr_r2);
        $result = array_unique($arr);
        $user = User::whereNotIn('id', $result)->get(['id', 'avatar', 'full_name', 'email']);
        return response()->json($user);
    }
}
