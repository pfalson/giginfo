<?php

namespace App\Repositories;

use App\Member;
use InfyOm\Generator\Common\BaseRepository;

class MemberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'primary_role',
        'biography'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Member::class;
    }
}
