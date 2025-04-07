<?php

namespace App\Repositories\Api;

use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements UserInterface
{
    public function __construct(protected User $model) {}

    // Register user
    // Register user
    public function register(array $credentials)
    {
        try {
            $user = $this->model::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'phone_number' => $credentials['phone_number'] ?? null,
                'address' => $credentials['address'] ?? null,
                'role' => 'reader'
            ]);

            $token = JWTAuth::fromUser($user);

            Cache::put('user_' . $user->id, $user, 1800);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => new UserResource($user),
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register user.', 'message' => $e->getMessage()], 500);
        }
    }

    // Login user
    public function login(array $credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        Cache::put('user_' . $user->id, $user, 1800);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }

    // Logout user
    public function logout(int $userId)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        // Optionally clear cache on logout
        Cache::forget('user_' . $userId);

        return response()->json(['message' => 'User logged out successfully']);
    }

    // Update user profile
    public function updateUserProfile(int $userId, array $data)
    {
        $user = $this->model->find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $validated = validator($data, [
            'name'         => ['sometimes', 'string', 'max:255'],
            'email'        => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $userId],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'address'      => ['nullable', 'string', 'max:255'],
        ])->validate();

        $user->fill($validated)->save();

        Cache::put('user_' . $userId, $user, 1800);

        return response()->json([
            'message' => 'User profile updated successfully.',
            'user'    => new UserResource($user)
        ]);
    }
}
