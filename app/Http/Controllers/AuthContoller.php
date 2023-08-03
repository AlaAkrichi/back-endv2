<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginUserRequest;
use App\Http\Requests\logoutRequest;
use App\Http\Requests\storUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthContoller extends Controller
{
    //
    use HttpResponses;
    public function Login(loginUserRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ];

        // Attempt authentication

        if (!Auth::attempt($credentials)) {
            $this->error([], "Credentials do not match", 401);
        }
        $user = User::where('email', $validatedData['email'])->first();
        // Authentication successful
        $token = $user->createToken("API token for " . $user->user_first_name . " " . $user->user_last_name)->plainTextToken;
        return $this->success([
            "user" => $user,
            "token" => $token
        ]);
    }
    public function Register(storUserRequest $request)
    {
        try {
            $request->validated($request->all());
            $user_id = Str::uuid()->toString();
            $user = User::create([
                "user_id" => $user_id,
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "date_of_birth" => $request->date_of_birth,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
            $token = $user->createToken("API token for " . $user->user_first_name . " " . $user->user_last_name)->plainTextToken;
            return $this->success([
                "user" => $user,
                'token' => $token,
            ]);
        } catch (Exception $e) {
            return $this->error([
                "erreur payload" => $e->getMessage()
            ], "somthing went wrong", 500);
        }
    }
    public function Logout(logoutRequest $request)
    {
        try {

            $user = request()->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return $this->success(["user" => "logout with succers"], 200);
        } catch (Exception $e) {
            return $this->error([
                "erreur payload" => $e->getMessage()
            ], "somting went wrong", 500);
        }
    }
}
