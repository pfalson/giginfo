<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use Validator;
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

		$user = Socialite::driver($provider)->user();

		// stroing data to our use table and logging them in
		$data = [
			'name' => $user->getName(),
			'email' => $user->getEmail()
		];

		$user = User::firstOrCreate($data);
		RegisterController::createMember($user);

		Auth::login($user);

		//after login redirecting to home page
		return redirect($this->redirectPath);
	}
}