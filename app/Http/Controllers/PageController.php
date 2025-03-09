<?php

namespace App\Http\Controllers;

use App\Actions\RegisterUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;

class PageController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function dashboard()
    {
        $user = Auth::user();
        return Inertia::render('Dashboard/Index')->with([
            'user' => $user,
            'number' => 9,
            'date' => "9-3-2567",
        ]);
    }

    public function userRegister()
    {
        return Inertia::render('Auth/Register');
    }

    public function storeRegister(Request $request, RegisterUserAction $userAction)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);
        $newUser = $userAction->execute(new User(), $request->all());
        Auth::login($newUser);
        return redirect()->route('index');
    }

//    public function login()
//    {
//        return Inertia::render('Auth/Login');
//    }
//
//    public function doLogin(Request $request)
//    {
//        $request->only('email', 'password');
//        $user = User::where('email', $request->email)->first();
//        dd($request->all());
//    }
}
