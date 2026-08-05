<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Simple Login helper model.
 *
 * This class provides a small wrapper to attempt authentication
 * from places that call into the model layer. Prefer using
 * controllers or services for full auth flows.
 */
class Login
{
	/**
	 * Attempt to authenticate a user using given credentials.
	 *
	 * @param  array  $credentials
	 * @param  bool   $remember
	 * @return bool
	 */
	public static function attempt(array $credentials, bool $remember = false): bool
	{
		return Auth::attempt($credentials, $remember);
	}

	/**
	 * Log the current user out.
	 *
	 * @return void
	 */
	public static function logout(): void
	{
		Auth::logout();
	}
}

