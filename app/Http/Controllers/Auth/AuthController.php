<?php

namespace App\Http\Controllers\Auth;

use Auth;
use DB;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//Add These three required namespace

use App\User;

class AuthController extends Controller
{
	use ThrottlesLogins;

	public function __construct()
	{
		$this->redirectPath = route('home');
	}

	public function redirectToProvider($provider)
	{
		return Socialite::driver($provider)->redirect();
	}

	public function handleProviderCallback($provider)
	{
		//notice we are not doing any validation, you should do it

		/** @var User $user */
		$user = Socialite::driver($provider)->user();

		// string data to our use table and logging them in
		/** @noinspection PhpUndefinedMethodInspection */
		$data = [
			'email' => $user->getEmail()
		];

		DB::beginTransaction();

		$user = User::firstOrNew($data);
		if (empty($user['name']))
		{
			/** @noinspection PhpUndefinedMethodInspection */
			$user->setAttribute('name', $user->getName());
		}
		$user->setAttribute('verified', 1);
		$user->save();

		RegisterController::createMember($user);

		DB::commit();

		Auth::login($user);

		//after login redirecting to home page
		/** @noinspection PhpUndefinedFieldInspection */
		return redirect($this->redirectPath);
	}
}