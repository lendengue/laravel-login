<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function recoveryPassword($input)
    {
		try {
            $user = User::where('username', $input['username'])
                ->where('email', $input['email'])
                ->first();

			if ($user) {
				$password = Str::randomNumber(8);
				
				$inputUpdate = [
					'password' => Hash::make($password),
                    'update_at' => date('Y-m-d H:i:s')
                ];
				
                DB::beginTransaction();
                DB::connection('sqlsrv');

                $updateCount = DB::table('tbl_user')
                    ->where('email', $user->email)
                    ->where('login', $user->login)
                    ->update($inputUpdate);

                if ($updateCount == 0) {
                    DB::rollBack();
                    return [
                        'success' => false,
                        'msg' => 'Error generating new password. Try again.'
                    ];
                }

                DB::commit();
                return [
                    'success' => true,
                    'password' => $password,
                    'name' => $user->name,
                    'email' => $user->email
                ];
			}
            return [
                'success' => false,
                'msg' => 'Username/Email not found.'
            ];
		} catch (\Exception $e) {
			return [
                'success' => false,
                'msg' => 'Error generating new password! Contact an administrator:'. $e->getMessage()
            ];
		}
	}

    public function changePassword($input)
    {
		try {
            if ($input['newPass'] != $input['confNewPass']) {
                return [
                    'success' => false,
                    'msg' => 'New passwords do not match.'
                ];
            }

            $username = session('username');

            if (!Hash::check($input['currentPass'], auth()->user()->password)) {
                return [
                    'success' => false,
                    'msg' => 'Incorrect current password.'
                ];
            }

			DB::beginTransaction();
            DB::connection('sqlsrv');
			
			$inputUpdate = [
                'password' => Hash::make($input['newPass']),
                'update_at' => date('Y-m-d H:i:s')
            ];
			
            $updateCount = User::where('username', $username)
                ->update($inputUpdate);
		
			if ($updateCount == 0) {
                return [
                    'success' => false,
                    'msg' => 'An error occurred while changing the password. Try again.'
                ];
			}

            DB::commit();
            return [
                'success' => true,
                'msg' => 'Password changed successfully.'
            ];
		} catch (\Exception $e) {
			return [
                'success' => false,
                'msg' => 'Error changing password! Contact an administrator:'. $e->getMessage()
            ];
		}
	}
}
