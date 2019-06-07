<?php
namespace App\Services;

use App\Models\Statistical;

class StatisticalService
{
    public static function addRow($film_id, $vote_id)
    {
        if (!empty($vote_id) && !empty($film_id)) {
            $data = Statistical::where(['vote_id' => $vote_id, 'films_id' => $film_id])->get();
            if ($data->count() == 0) {
                $statistical = new Statistical;
                $statistical->vote_id = $vote_id;
                $statistical->films_id = $film_id;
                $statistical->amount_votes += 1;
                $statistical->save();
            } else {
                foreach ($data as $value) {
                    $value->amount_votes += 1;
                    $value->save();
                }
            }
        }
    }
}
