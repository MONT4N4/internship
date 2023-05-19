<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function update(Request $request, $user_id)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($user_id);

        // Verify if the provided current password matches the user's current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match the user\'s current password.'],
            ]);
        }

        // Update the user's password with the new hashed password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully for user: ' . $user->id]);
    }
}
