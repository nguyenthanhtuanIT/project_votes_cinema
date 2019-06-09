<?php
namespace App\Services;

use App\Models\Vote;

class VoteService
{
    public static function addTicket($vote_id, $number)
    {
        $v = Vote::find($vote_id);
        $v->total_ticket += $number;
        $v->save();
    }
    public static function updateTicket($vote_id, $number_old, $number_new)
    {
        $v = Vote::find($vote_id);
        $v->total_ticket -= $number_old;
        $v->total_ticket += $number_new;
        $v->save();
    }
    public static function deleteTicket($vote_id, $number)
    {
        $v = Vote::find($vote_id);
        $v->total_ticket -= $number;
        $v->save();
    }
}
