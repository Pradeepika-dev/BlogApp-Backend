<?php 

namespace App\Repositories\User;

use App\Http\Requests\UserRequest;
use App\Repositories\User\Contract\UserAuthInterface;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class UserAuthRepository implements UserAuthInterface
{
    use ApiResponse;

    public function register(UserRequest $request)
    {
        try {
            $user = User::create($request->all());
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success("User Registered Successfully", ['user' => $user, 'token' => $token]);
        }catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
        
    }

    public function login(UserRequest $request)
    {
        try {
            // Check if user exists, and password is correct
            $user = User::where('email',$request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                //return $this->error("Invalid Credentials", 401);
				return [
					'errors' => [
						'email' => 'Invalid Credentials'
					]
				];
            }

            // Get the token for the user
            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

            return $this->success("User Logged Successfully", ['user' => $user, 'token' => $token]);
        }catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function logout($request)
    {
        try {
            $request->user()->tokens()->delete();
            return $this->success("User Logged Successfully",[],200);
        }catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}