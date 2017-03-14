<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\Role;
use Modules\Admin\Entities\User;
use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\GenericAdminController;

class UserController extends GenericAdminController
{

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

        $this->validate($request, $this->getValidationArray($this->model::getCreateFields()));

        $credentials = [
            'first_name' => $request->input('first_name', null),
            'last_name' => $request->input('last_name', null),
            'email' => $request->input('email', null),
            'password' => $request->input('password', null)
        ];

        $user = Sentinel::registerAndActivate($credentials);

        if ($user) {
            if ($request->ajax()) {
                return new JsonResponse([
                    'user' => $user,
                    'redirect' => route($this->edit_route, $user->id)
                ], 201);
            } else {
                return redirect()->route($this->edit_route, $user->id);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $user = $this->model::findOrFail($id);


        return view('admin::users.edit', [
            'user' => $user,
            'edit_fields' => $this->model::getUpdateFields(),
            'roles' => Role::pluck('name', 'id'),
            'user_roles' => $user->roles->pluck('id')->all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = EloquentUser::find($id);

        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);
        $user->email = $request->input('email', $user->email);
        $user->save();

        $roles = Role::all();
        foreach ($roles as $role) {
            $role = Sentinel::findRoleById($role);
            $role->users()->detach($user);
        }

        $roles = $request->input('roles', []);

        foreach ($roles as $role) {
            $role = Sentinel::findRoleById($role);
            $role->users()->attach($user);
        }

        $user = Sentinel::findById($user->id);

        if ($request->input('password', null) !== null) {
            Sentinel::update($user, array('password' => $request->input('password')));
        }

        return redirect()->route('admin.users.index');

    }

    protected function timeAgo($row)
    {
        if (isset($row->last_login) && $row->last_login !== '') {
            $dt = new Carbon($row->last_login);
            return $dt->diffForHumans();
        } else {
            return trans('admin::users.never');
        }
    }


}
