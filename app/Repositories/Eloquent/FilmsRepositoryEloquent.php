<?php

namespace App\Repositories\Eloquent;

use App\Models\Films;
use App\Models\Statistical;
use App\Models\Vote;
use App\Presenters\FilmsPresenter;
use App\Repositories\Contracts\filmsRepository;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FilmsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class FilmsRepositoryEloquent extends BaseRepository implements FilmsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Films::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return FilmsPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function create(array $attributes)
    {
        $attributes['curency'] = 'đ';
        $name = $attributes['img']->store('photos');
        $link = Storage::url($name);
        $attributes['img'] = $link;
        $film = parent::create($attributes);
        return response()->json($film);
    }
    public function update(array $attributes, $id)
    {

        if (isset($attributes['img'])) {
            $name = $attributes['img']->store('photos');
            $link = Storage::url($name);
            $attributes['img'] = $link;

            $img = Films::find($id);
            $imgold = $img->img;
            $nameimg = explode('/', $imgold);
            // dd($nameimg[5]);
            Storage::delete('/photos/' . $nameimg[5]);
        }
        $film = parent::update($attributes, $id);
        return response()->json($film);
    }
    public function delete($id)
    {
        $vote = vote::all();
        foreach ($vote as $val) {
            $list = $val->list_films;
            for ($i = 0; $i < count($list); $i++) {
                if ($list[$i] == $id) {
                    unset($list[$i]);
                    $str = implode(',', $list);
                    Vote::where('id', $val->id)->update(['list_films' => $str]);
                }
            }
        }
        $film = parent::delete($id);
        return response()->json(null, 204);
    }
    public function getlistFilmToVote()
    {
        $vote = Vote::where('status_vote', 'voting')->first();
        if (!empty($vote)) {
            //$list = $vote->list_films;
            $str = implode(',', $vote->list_films);
            $arr = explode(',', $str);
            for ($i = 0; $i < count($arr); $i++) {
                $film = Films::find($arr[$i]);
                $a[] = $film;
            }
            return response()->json($a);
        } else {
            return response()->json(['status' => 'not data']);
        }
    }
    public function filmToRegister($vote_id)
    {
        $check = Statistical::where(['vote_id' => $vote_id, 'movie_selected' => 1])->get();
        if ($check->count() != 1) {
            $max = Statistical::where('vote_id', $vote_id)->max('amount_votes');
            $statistical = Statistical::where(['vote_id' => $vote_id, 'amount_votes' => $max])->get();
            if (count($statistical) == 1) {
                foreach ($statistical as $f) {
                    $film = Films::find($f->films_id);
                    Statistical::where(['vote_id' => $vote_id, 'amount_votes' => $max])->update(['movie_selected' => 1]);
                    return $film;
                }
            } else {
                $rand = Statistical::where(['vote_id' => $vote_id, 'amount_votes' => $max])->get()->random();
                $films = Films::find($rand->films_id);
                Statistical::where(['vote_id' => $vote_id, 'films_id' => $films->id])->update(['movie_selected' => 1]);
                return $films;
            }

        } else {
            foreach ($check as $value) {
                return $film = Films::find($value->films_id);
            }
        }
    }
}
