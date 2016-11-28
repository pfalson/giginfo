<?php

namespace App\Repositories;

use App\State;
use InfyOm\Generator\Common\BaseRepository;

class StateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'country_id',
        'abbr'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return State::class;
    }
}
