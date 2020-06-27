<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('home');
    }

//    /**
//     * Get data of current user.
//     *
//     * @return mixed
//     */
//    public function profileData() {
//        $user = \Auth::user();
//        return response()->json($user);
//    }

    /**
     * Update user profile.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function profileUpdate(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'nullable|min:3|string|max:100',
            'image' => 'required'
        ]);

        $user = \Auth::user();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->save();

        return response()->json($user);
    }
}
