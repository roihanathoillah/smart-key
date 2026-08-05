<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Simple Register helper for registering users.
 */
class Register
{
	/**
	 * Create a new user record.
	 *
	 * @param  array  $data
	 * @return \App\Models\User
	 */
	public static function create(array $data): User
	{
		$user = User::create([
			'name' => $data['name'] ?? null,
			'email' => $data['email'] ?? null,
			'password' => Hash::make($data['password'] ?? ''),
		]);

		return $user;
	}
}

