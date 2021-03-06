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
    public static function updateRow($film_id, $vote_id)
    {
        $data = Statistical::where(['vote_id' => $vote_id, 'films_id' => $film_id])->get();
        foreach ($data as $value) {
            $value->amount_votes -= 1;
            $value->save();
        }
    }
    public static function addRegister($film_id, $vote_id)
    {
        $data = Statistical::where(['vote_id' => $vote_id, 'films_id' => $film_id])->first();
        $data->amount_registers += 1;
        $data->save();
    }
    public static function updateRegister($film_id, $vote_id)
    {
        $data = Statistical::where(['vote_id' => $vote_id, 'films_id' => $film_id])->first();
        $data->amount_registers -= 1;
        $data->save();

    }
}
