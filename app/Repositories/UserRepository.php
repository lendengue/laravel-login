<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function verifyCredentials($username, $password)
    {
		try {
			$user = User::where('username', $username)->first();

            if (!$user) {
                return false;
            }
            
            if (Hash::check($password, $user->password)) {
                return true;
            }

            return false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}
