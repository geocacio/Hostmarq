<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 1200,
            'user' => auth()->user(),
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::find(auth()->user()->id);
        $token = JWTAuth::fromUser($user);

        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 1200,
            'user' => $user->toArray(),
        ];

        return response()->json($response, 200);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'role_id' => 'nullable|integer|exists:roles,id',
            'password' => 'required|string|min:6|max:100',
            'club_id' => 'nullable|integer|exists:clubs,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Verifique se o usuário autenticado tem a permissão para criar este tipo de usuário
        $role = Role::find($request->input('role_id'));

        $userLogged = User::find(auth()->user()->id);
        if (!$userLogged || !$userLogged->hasPermission('create-' . $role->name)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'registration' => $this->generateMatricula(),
            'password' => bcrypt($request->password),
        ]);

        if (isset($request->role_id)) {
            $user->roles()->attach($request->input('role_id'));
        }

        //Se o usuário for dono de um clube, adicionar o usuário ao clube (user_clube)
        if ($userLogged->hasRole('clubMaster') || $userLogged->hasRole('clubAdmin')) {
            $club = Club::find($request->input('club_id'));
            if ($club) {
                $club->users()->attach($user->id);
            }
        }

        $response = [
            'user' => $user->toArray(),
        ];

        return response()->json($response, 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function generateMatricula()
    {
        $lastUser = User::orderBy('created_at', 'desc')->first();
        $lastMatricula = $lastUser ? $lastUser->matricula : 0;

        $newMatricula = $lastMatricula + 1;

        return str_pad($newMatricula, 4, '0', STR_PAD_LEFT);
    }
}
