<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function loggedInUser()
    {
        try{
            $user = User::where('id', auth()->user()->id)->get();
            return response()->json(new UserCollection($user), 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // public function updateUserImage(Request $request)
    // {
    //     $request->validate(['image' => 'required|mimes:png,jpg,jpeg']);
    //     if ($request->height === '' || $request->width === '' || $request->top === '' || $request->left === '') {
    //         return response()->json(['error' => 'The dimensions are incomplete'], 400);
    //     }

    //     try {
    //         $user = (new FileService)->updateImage(auth()->user(), $request);
    //         $user->save();

    //         return response()->json(['success' => 'OK'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'success' => 'OK',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($request->id)],
        ]);

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
