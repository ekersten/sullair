<?php

namespace Modules\Admin\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Reminders\EloquentReminder;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Emails\PasswordReset;

class AdminController extends Controller
{

    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::dashboard');
    }

    public function login(Request $request) {
        if($request->isMethod('get')) {
            return view('admin::login');
        } elseif ($request->isMethod('post')) {
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

    }

    public function logout() {
        Sentinel::logout();

        return redirect()->route('admin.login')->with('flashSuccess', 'You have succesfully logged out');
    }

    public function email(Request $request, $code) {

        $reminder = EloquentReminder::where('code', $code)->first();

        return view('admin::reset', [
            'token' => $code
        ]);
    }

    public function reset(Request $request) {
        if($request->isMethod('get')) {
            return view('admin::email', ['token' => csrf_token()]);
        } elseif ($request->isMethod('post')) {

            if(boolval($request->input('token', false) !== false)) {
                $this->validate($request, [
                    'token'                     => 'required|exists:reminders,code',
                    'email'                     => 'required|email|exists:users',
                    'password'                  => 'required|confirmed',
                    'password_confirmation'     => 'required|same:password'
                ]);

                $user = Sentinel::findByCredentials([
                    'email' => $request->input('email')
                ]);

                if ($user->reminders->where('code', $request->input('token'))) {
                    Reminder::complete($user, $request->input('token'), $request->input('password'));

                    return redirect()->route('admin.admin.dashboard');
                } else {
                    return back()->withErrors(['email' => 'invalid code for mail']);
                }

            } else {
                $this->validate($request, [
                    'email' => 'required|email|exists:users'
                ]);

                $user = Sentinel::findByCredentials([
                    'email' => $request->input('email')
                ]);

                $reminder = Reminder::create($user);

                Mail::to($user->email)->send(new PasswordReset($reminder));

                // TODO: redirect or message
            }
        }

    }

}
