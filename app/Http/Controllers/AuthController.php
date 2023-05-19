<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\VerificationMail;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $verification_code = Str::random(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => 'student',
            'email_verified' => false,
            'verification_code' => $verification_code,
        ]);

        $verification_code = rand(100000, 999999);
        $user->verification_code = $verification_code;
        $user->save();

        Mail::to($user)->send(new VerificationMail($user)); // pass $user instead of $request->email



        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function verifyEmail (Request $request): JsonResponse
    {
        $code = User::findOrFail($request->user_id)->verification_code;
        if ($code != $request->code) {
            return Response()->json(['error' => 'Invalid verification code try again']);
        }

            $user = User::findOrFail($request->user_id);
            $user->email_verified_at = date("Y-m-d h:i:sa");
            $user->save();
            return Response()->json(['message' => "email verified successfully"]);

    }





    /**
     * Log the user in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->email_verified_at) {
                return response()->json(['error' => 'Email not verified'], 401);
            }
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Log the user out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * Send a verification code to the user's email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

}
