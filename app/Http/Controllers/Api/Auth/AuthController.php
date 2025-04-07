<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserProfileRequest;
use App\Repositories\UserInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends AuthBaseController
{
    use ApiResponseTrait;
    // Register user
    public function register(UserRegisterRequest $request)
    {
        try {
            $data = $request->validated();
            return $this->repository->register($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'An error occurred during registration.'], 500);
        }
    }

    // Login user
    public function login(UserLoginRequest $request)
    {
        try {
            $data = $request->validated();
            return $this->repository->login($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'An error occurred during login.'], 500);
        }
    }

    // Logout user
    public function logout(Request $request)
    {
        try {
            $userId = auth()->id();
            return $this->repository->logout($userId);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'An error occurred during logout.'], 500);
        }
    }

    public function updateUserProfile(UserProfileRequest $request){
        try {
            $userId = auth()->id();
            $data = $request->validated();
            return $this->repository->updateUserProfile($userId, $data);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'An error occurred during user profile update.'], 500);
        }
    }
}
