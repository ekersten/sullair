<?php

namespace Modules\Admin\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\User;
use Modules\Admin\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin::users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::users.edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $credentials = [
            'first_name' => $request->input('first_name', null),
            'last_name' => $request->input('last_name', null),
            'email' => $request->input('email', null),
            'password' => $request->input('password', null)
        ];

        $user = Sentinel::registerAndActivate($credentials);

        if($user) {
            return redirect()->route('users.index');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::users.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin::users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        dd($user);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
