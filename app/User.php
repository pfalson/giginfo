<?php

namespace App;

use App\Models\Member;
use Auth;
use Backpack\Base\app\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Traits\UserVerification;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\User search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Query\Builder|\App\User searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property boolean $confirmed
 * @property string $confirmation_code
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmationCode($value)
 * @property bool $verified
 * @property string $verification_token
 * @method static \Illuminate\Database\Query\Builder|\App\User whereVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereVerificationToken($value)
 */
class User extends Authenticatable
{
    use Notifiable;
	use SearchableTrait;
	use VerifiesUsers;
	use UserVerification;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	protected $searchable = [
		'columns' => [
			'name' => 10
		]
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function member()
	{
		return $this->hasOne(Member::class);
	}

	/**
	 * @param \Eloquent $builder
	 */
	public function scopeDetails($builder)
	{
		$user = Auth::user();
		if ($user !== null)
		{
			$builder->select()
				->join('members as m', 'm.user_id', 'users.id')
				->select([
					'users.*',
					'm.primary_role as primary_role',
					'm.biography as biography'
				]);
		}
	}

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}
}
