<?php

namespace App\Repositories\Eloquent;

use App\Models\Vote;
use App\Presenters\VotePresenter;
use App\Repositories\Contracts\VoteRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class VoteRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class VoteRepositoryEloquent extends BaseRepository implements VoteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vote::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return VotePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function search($title)
    {
        $result = $this->model()::where('name_vote', 'like', '%' . $title . '%')->get();
        return $result;
    }
    public function create(array $attributes)
    {
        $name = $attributes['background']->store('photos');
        $link = Storage::url($name);
        $attributes['background'] = $link;
        $vote = parent::create($attributes);
        return $vote;
        // $user = User::all();
        // foreach ($user as $us) {
        //     $email = new NotificationMessage($us);
        //     Mail::to($us->email)->send($email);
        // }
    }
    public function update(array $attributes, $id)
    {
        if (isset($attributes['background'])) {
            $name = $attributes['background']->store('photos');
            $link = Storage::url($name);
            $attributes['background'] = $link;
            $img = Vote::find($id);
            $imgold = $img->background;
            $nameimg = explode('/', $imgold);
            Storage::delete('/photos/' . $nameimg[5]);
        }
        $vote = parent::update($attributes, $id);
        return $vote;
    }
    public function getStatus()
    {
        $data[] = array('created', 'end');
        $vote = Vote::whereNotIn('status_vote', $data)->first();
        $date = Carbon::now()->toDateString();
        if ($vote->time_registing <= $date && $date < $vote->time_booking_chair && $vote->status_vote != 'registing') {
            $update = Vote::where('id', $vote->id)->update(['status_vote' => 'registing']);
        } elseif ($vote->time_booking_chair <= $date && $date < $vote->time_end && $vote->status_vote != 'booking_chair') {
            $update = Vote::where('id', $vote->id)->update(['status_vote' => 'booking_chair']);
        } elseif ($date >= $vote->time_end && $vote->status_vote != 'end') {
            $update = Vote::where('id', $vote->id)->update(['status_vote' => 'end']);
        }
        $v = Vote::find($vote->id);
        return response()->json(['id' => $v->id, 'status' => $v->status_vote]);
    }
}
