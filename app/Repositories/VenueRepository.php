<?php

namespace App\Repositories;

use App\Venue;
use InfyOm\Generator\Common\BaseRepository;

class VenueRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'website',
        'facebook',
        'address_id',
        'phone'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Venue::class;
    }
}
