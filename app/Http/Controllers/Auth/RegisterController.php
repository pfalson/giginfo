<?php

namespace App\Http\Controllers\Auth;

use App\Models\ArtistRole;
use App\Models\Member;
use App\User;
use Illuminate\Http\Request;
use Jrean\UserVerification\Traits\VerifiesUsers;
use UserVerification;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;
	use VerifiesUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
	}

	/**
	 * @param User $user
	 */
	public static function createMember($user)
	{
		$memberRole = ArtistRole::whereCode('m')->first();
		Member::firstOrCreate(['user_id' => $user->id, 'primary_role' => $memberRole->id]);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name'     => 'required|max:255',
			'email'    => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data)
	{
		$user = User::create([
			'name'              => $data['name'],
			'email'             => $data['email'],
			'password'          => bcrypt($data['password'])
		]);

		return $user;
	}

	public function confirm()
	{
		dd('confirm');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{
		/** @noinspection PhpUndefinedMethodInspection */
		$this->validator($request->all())->validate();

		$user = $this->create($request->all());
		$this->guard()->login($user);

		/** @noinspection PhpUndefinedClassInspection */
		UserVerification::generate($user);
		/** @noinspection PhpUndefinedClassInspection */
		UserVerification::send($user, 'GigInfo Email Verification');

		/** @noinspection PhpUndefinedMethodInspection */
		\Alert::success('Check your email for a verification link')->flash();

		return redirect($this->redirectPath());
	}

	/**
	 * Handle the user verification.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getVerification(Request $request, $token)
	{
		$this->validateRequest($request);

		try {
			UserVerification::process($request->input('email'), $token, $this->userTable());
		} catch (UserNotFoundException $e) {
			return redirect($this->redirectIfVerificationFails());
		} catch (UserIsVerifiedException $e) {
			return redirect($this->redirectIfVerified());
		} catch (TokenMismatchException $e) {
			return redirect($this->redirectIfVerificationFails());
		}

		$user = User::where('email', $request->input('email'))->firstOrFail();

		self::createMember($user);

		return redirect($this->redirectAfterVerification());
	}
}