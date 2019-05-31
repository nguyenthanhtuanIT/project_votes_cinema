<?php

namespace App\Models;

/**
 * Class Chair.
 *
 * @package namespace App\Models;
 */
class Chair extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vote_id', 'row_of_seats', 'amount_chairs', 'status_chairs'];
    protected $hidden = [];
    public function getchair()
    {
        $data[] = array();
        $data = explode(',', $this->status_chairs);
        return $data;
    }
}
