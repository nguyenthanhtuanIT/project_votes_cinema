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
    public function getlistFilmToVote()
    {
        $vote = Vote::where('status_vote', 'voting')->first();
        if (!empty($vote)) {
            $list = $vote->list_films;
            $arr = explode(',', $list);
            for ($i = 0; $i < count($arr); $i++) {
                $film = Films::find($arr[$i]);
                $a[] = $film;
            }
            return response()->json($a);
        } else {
            return response()->json(['status' => 'not data']);
        }
    }
    // public function listFilmMaxVote()
    // {
    //     $vote = Vote::where('status_vote', 2)->orwhere('status_vote', 1)->select('id', 'status_vote')->first();
    //     $max = $this->model()::where('vote_id', $vote->id)->max('vote_number');
    //     $films = $this->model()::where('vote_id', $vote->id)->where('vote_number', $max)
    //         ->get();
    //     return $films;
    // }
    // public function totalTicket(array $attributes)
    // {
    //     $film_id = $attributes['film_id'];
    //     $vote_id = $attributes['vote_id'];
    //     $total = $this->model()::where(['id' => $film_id, 'vote_id' => $vote_id])->first();
    //     return $total->register_number;
    // }
    // public function searchFilms($keyword)
    // {
    //     $data = $this->model()::where('projection_date', $keyword)->orwhere('type_cinema_id', $keyword)->get();
    //     return $data;
    // }
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
                Statistical::where(['vote_id' => $vote_id, 'films_id' => $films->films_id])->update(['movie_selected' => 1]);
                return $films;
            }

        } else {
            foreach ($check as $value) {
                return $film = Films::find($value->films_id);
            }
        }
    }
}
