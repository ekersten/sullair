<?php

namespace Modules\Admin\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\User;
use Modules\Admin\Http\Requests\UserRequest;

class UserController extends GenericAdminController {

    protected $model = User::class;
    protected $index_template = 'admin::users.index';
    protected $show_template = 'admin::users.show';

    // strtolower(substr($model, strrpos($model, '\\') + 1));


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
