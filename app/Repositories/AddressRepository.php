<?php

namespace App\Repositories;

use App\Address;
use InfyOm\Generator\Common\BaseRepository;

class AddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city_id',
        'street_number',
        'street_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Address::class;
    }
}
