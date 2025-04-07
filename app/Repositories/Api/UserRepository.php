<?php

namespace App\Repositories\Api;

use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements UserInterface
{
    use ApiResponseTrait;

    public function __construct(protected User $model) {}

    // Register user
    public function register(array $credentials)
    {
        try {
            $user = $this->model::create([
                'name'         => $credentials['name'],
                'email'        => $credentials['email'],
                'password'     => Hash::make($credentials['password']),
                'phone_number' => $credentials['phone_number'] ?? null,
                'address'      => $credentials['address'] ?? null,
                'role'         => 'reader'
            ]);

            $token = JWTAuth::fromUser($user);
            Cache::put('user_' . $user->id, $user, 1800);

            return $this->successResponse([
                'user'  => new UserResource($user),
                'token' => $token
            ], 'User registered successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to register user: ' . $e->getMessage(), 500);
        }
    }

    // Login user
    public function login(array $credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $user = Auth::user();
        Cache::put('user_' . $user->id, $user, 1800);

        return $this->successResponse([
            'user'  => new UserResource($user),
            'token' => $token
        ], 'Login successful');
    }

    // Logout user
    public function logout(int $userId)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        Cache::forget('user_' . $userId);

        return $this->successResponse(null, 'User logged out successfully');
    }

    // Update user profile
    public function updateUserProfile(int $userId, array $data)
    {
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->errorResponse('User not found.', 404);
        }

        $validator = validator($data, [
            'name'         => ['sometimes', 'string', 'max:255'],
            'email'        => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $userId],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'address'      => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $user->fill($validator->validated())->save();
        Cache::put('user_' . $userId, $user, 1800);

        return $this->successResponse(new UserResource($user), 'User profile updated successfully.');
    }
}
