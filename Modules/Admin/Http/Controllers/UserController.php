<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\User;
use Modules\Admin\Http\Requests\UserRequest;

class UserController extends GenericAdminController {

    protected $model = User::class;

    protected $index_template = 'admin::users.index';
    protected $edit_template = 'admin::users.edit';

    protected $permissions_prefix = 'users';

    protected $index_route = 'admin.users.index';
    protected $store_route = 'admin.users.store';
    protected $edit_route = 'admin.users.edit';
    protected $delete_route = 'admin.users.destroy';

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $credentials = [
            'first_name' => $request->input('first_name', null),
            'last_name' => $request->input('last_name', null),
            'email' => $request->input('email', null),
            'password' => $request->input('password', null)
        ];

        $user = Sentinel::registerAndActivate($credentials);

        if($user) {
            if ($user) {
                return redirect()->route($this->edit_route, $user->id);
            }
        }
    }

    protected function timeAgo($row) {
        if (isset($row->last_login) && $row->last_login !== '') {
            $dt =  new Carbon($row->last_login);
            return $dt->diffForHumans();
        } else {
            return trans('admin::users.never');
        }
    }


}
