<?php

namespace App\Exports;

use App\Models\Films;
use App\Models\Register;
use App\Models\Vote;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getUsers()
    {
        $register = Register::all();
        $user = User::all();
        foreach ($register as $r) {
            foreach ($user as $u) {
                if ($r->user_id == $u->id) {
                    $name = $u->full_name;
                }
            }
        }
        return $name;
    }
    public function getEmails()
    {
        $register = Register::all();
        $user = User::all();
        foreach ($register as $r) {
            foreach ($user as $u) {
                if ($r->user_id == $u->id) {
                    $email = $u->email;
                }
            }
        }
        return $email;
    }
    public function getVotes()
    {
        $register = Register::all();
        $votes = Vote::all();
        foreach ($register as $r) {
            foreach ($votes as $v) {
                if ($r->vote_id == $v->id) {
                    $vote = $v->name_vote;
                }
            }
        }
        return $vote;
    }
    public function getFilms()
    {
        $register = Register::all();
        $films = Films::all();
        foreach ($register as $r) {
            foreach ($films as $f) {
                if ($r->film_id == $f->id) {
                    $film = $f->name_film;
                }
            }
        }
        return $film;
    }
    public function getbestfriend()
    {
        $register = Register::all();
        $user = User::all();
        $u = array();
        foreach ($register as $res) {
            //$str = implode(',', );
            $arr = explode(',', $res->best_friend);
            for ($i = 0; $i < count($arr); $i++) {
                foreach ($user as $us) {
                    if ($arr[$i] == $us->id) {
                        $u[] = $us->full_name;
                    }
                }
            }
            return $u;
        }

    }
    public function collection()
    {
        $register = Register::all();
        if (count($register) > 0) {
            foreach ($register as $reg) {
                $data[] = array(
                    '0' => $this->getUsers(),
                    '1' => $this->getEmails(),
                    '2' => $this->getVotes(),
                    '3' => $this->getFilms(),
                    '4' => $reg->ticket_number,
                    '5' => $this->getbestfriend());
            }
            return (collect($data));
        } else {
            $data[] = array();
            return (collect($data));
        }

    }
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Name_vote',
            'Name_film',
            'Ticket_number',
            'Best friend',
        ];
    }
}
