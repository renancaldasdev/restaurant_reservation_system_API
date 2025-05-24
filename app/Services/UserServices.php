<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserServices
{
    public function registerDataUser($request, $nameRole): array
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $role = Role::where('name', $nameRole)->first();

        if ($role) {
            $user->roles()->attach($role->id);
        }

        $token = JWTAuth::fromUser($user);

        return [$user, $token];
    }
}
