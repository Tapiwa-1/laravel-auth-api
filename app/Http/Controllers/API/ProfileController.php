<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PasswordUpdateRequest;
use App\Http\Resources\ProfileDeleteRequest;
use App\Http\Resources\ProfileUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request) 
    {
        try {
            return response()->json([
                'success' => 'OK',
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function getProfile()
    {
        try{
            $user = User::where('id', auth()->user()->id)->get();
            return response()->json(new UserCollection($user), 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
      /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)  
    {
        try {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            $request->user()->save();

            return response()->json([
                'success' => 'OK',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
     /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
            
            return response()->json([
                'success' => 'OK',
            ], 200);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Delete the user's account.
     */
    public function destroy(ProfileDeleteRequest $request)
    {
        try {
            $request->validated();
            $user = $request->user();

            $user->delete();
            
            return response()->json([
                'success' => 'OK',
            ], 200);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
