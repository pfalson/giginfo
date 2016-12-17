<?php

namespace App\Repositories;

use App\Street;
use InfyOm\Generator\Common\BaseRepository;

class StreetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Street::class;
    }
}
