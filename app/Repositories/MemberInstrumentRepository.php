<?php

namespace App\Repositories;

use App\MemberInstrument;
use InfyOm\Generator\Common\BaseRepository;

class MemberInstrumentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'member_id',
        'instrument_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MemberInstrument::class;
    }
}
