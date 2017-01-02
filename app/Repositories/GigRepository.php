<?php

namespace App\Repositories;

use App\Models\Gig;
use InfyOm\Generator\Common\BaseRepository;

class GigRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'artist_id',
        'venue_id',
        'start',
        'finish',
        'description',
        'poster',
        'price',
        'age',
        'type',
        'name',
        'ticketurl'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gig::class;
    }
}
