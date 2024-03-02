<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(StoreLoginRequest $request){
        $credentials = $request->only('email','password');
        $user = User::where('email', $credentials['email'])->first();

        if(!$user && !Hash::check($credentials['password'],$user->password)){
            return response()->json(['error'=>"Provided email or password is not correct."],422);
        }
        $user = User::where('email',$credentials['email'])->first();
        $token = $user->createToken("api token of $user->name")->plainTextToken;
        return response()->json([
            'token' => $token,
            'user'=>$user
        ],200);
    }
    public function index(){
        $users = User::latest('id')->get();
        return response()->json(UserResource::collection($users),200);
    }

    public function show($id){
        $user = User::find($id);
        if(!$user){
            return response()->json('User not found',404);
        }
        return response()->json(new UserResource($user),200);
    }

    public function store(StoreUserRequest $request){
        $user = User::create($request->all());
        return response()->json(new UserResource($user),200);
    }

    public function update(UpdateUserRequest $request, User $user){
        $user->update($request->all());
        return response()->json(new UserResource($user),200);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null,204);
    }
}
