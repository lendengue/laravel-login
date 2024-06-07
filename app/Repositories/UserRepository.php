<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function verifyCredentials($username, $password)
    {
		try {
			return User::where('username', $username)
                ->where('password', $password)
                ->first();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}
