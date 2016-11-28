<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberInstrument
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $member_id
 * @property integer $instrument_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberInstrument whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberInstrument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberInstrument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberInstrument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberInstrument whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberInstrument whereInstrumentId($value)
 * @mixin \Eloquent
 */
class MemberInstrument extends Elegant
{

	protected $table      = 'member_instruments';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('member_id', 'instrument_id');

}