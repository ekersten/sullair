<?php

namespace Modules\Admin\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::dashboard');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function login(Request $request) {
        return view('admin::login');
    }

    public function doLogin(Request $request) {
        $loginResult = Sentinel::authenticate(array(
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ));

        if ($loginResult !== false) {
            return redirect()->route('admin.admin.dashboard');
        } else {
            return back()->withInput();
        }

    }

    public function logout() {
        Sentinel::logout();

        return redirect()->route('admin.login')->with('flashSuccess', 'You have succesfully logged out');
    }

    public function email(Request $request) {
        return view('admin::email');
    }

    public function reset(Request $request) {
        return view('admin::reset', ['token' => csrf_token()]);
    }

}
