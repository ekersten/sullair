<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Nwidart\Modules\Facades\Module;
use Illuminate\Http\JsonResponse;


class RoleController extends GenericAdminController
{

    protected $model = Role::class;

    protected $index_template = 'admin::roles.index';
    protected $edit_template = 'admin::roles.edit';

    protected $permissions_prefix = 'roles';

    protected $index_route = 'admin.roles.index';
    protected $store_route = 'admin.roles.store';
    protected $edit_route = 'admin.roles.edit';
    protected $delete_route = 'admin.roles.destroy';


    public function store(Request $request)
    {

        $this->validate($request, $this->getValidationArray($this->model::getCreateFields()));

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
        ]);

        if ($role) {
            if($request->ajax()) {
                return new JsonResponse($role, 201);
            } else {
                return redirect()->route($this->edit_route, $role->id);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Role $role
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $role = Sentinel::findRoleById($id);
        $permissions = [];
        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            if (file_exists($module->getExtraPath('Permissions') . DIRECTORY_SEPARATOR . 'permissions.php')) {
                $permissions[$module->getLowerName()] = include $module->getExtraPath('Permissions') . DIRECTORY_SEPARATOR . 'permissions.php';
            }
        }

        return view('admin::roles.edit', [
            'update_fields' => $this->model::getUpdateFields(),
            'role' => $role,
            'modules' => Module::getOrdered(),
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param  Role $role
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $role = Role::findOrFail($id);

        $role->name = $request->input('name');
        $role->slug = str_slug($request->input('name'));

        $role->save();

        // cambiar al objeto de Sentinel para usar los permisos
        $role = Sentinel::findRoleById($role->id);
        $role->permissions = [];

        $modules = Module::getOrdered();
        foreach($modules as $module) {
            if (file_exists($module->getExtraPath('Permissions') . DIRECTORY_SEPARATOR . 'permissions.php')) {
                $module_permissions = include $module->getExtraPath('Permissions') . DIRECTORY_SEPARATOR . 'permissions.php';
                foreach($module_permissions as $permission) {
                    $role->addPermission($permission, boolval($request->input(str_replace('.', '_', $permission), false)));
                }
            }
        }

        $role->save();

        return redirect()->route('admin.roles.index');
    }

}