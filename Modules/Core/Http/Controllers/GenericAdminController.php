<?php

namespace Modules\Core\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;

class GenericAdminController extends Controller
{

    use ValidatesRequests;

    protected $model = '';

    protected $index_template = '';
    protected $show_template = '';
    protected $edit_template = '';

    protected $index_route = '';
    protected $store_route = '';
    protected $edit_route = '';
    protected $delete_route = '';

    protected $permissions_prefix = '';

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->getData();
        } else {
            $fields = $this->model::getListFields();
            $create_fields = $this->model::getCreateFields();

            // agregar la columna de acciones solo si puede editar o eliminar
            if ($this->hasActionsColumn()) {
                $fields['actions'] = [
                    'label' => trans('admin::admin.actions'),
                    'searchable' => false,
                    'orderable' => false,
                    'className' => 'text-center',
                ];
            }

            return view($this->index_template, [
                'fields' => $fields,
                'create_fields' => $create_fields,
                'store_route' => $this->store_route
            ]);
        }


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
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request)
    {
        $item = $this->model::get($id);
        if ($item) {
            if ($request->ajax()) {
                return item;
            } else {
                return view($this->show_template, ['item' => $item]);
            }
        } else {
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $item = $this->model::find($id);
        if ($item) {
            if ($request->ajax()) {
                return item;
            } else {
                return view($this->edit_template, ['item' => $item]);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);

        if ($item->delete()) {
            $response = trans('admin::admin.deleted');
        } else {
            $response = trans('admin::admin.error_delete');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse($response, 200);
        } else {
            return redirect()->route($this->index_route)->with('flashSuccess', $response);
        }
    }

    private function getPermissions()
    {
        if ($user = Sentinel::getUser()) {
            if ($this->permissions_prefix !== '') {
                return [
                    'create' => $user->hasAccess($this->permissions_prefix . '.create'),
                    'read' => $user->hasAccess($this->permissions_prefix . '.read'),
                    'update' => $user->hasAccess($this->permissions_prefix . '.update'),
                    'delete' => $user->hasAccess($this->permissions_prefix . '.delete'),
                ];
            }
        } else {
            return [];
        }
    }

    private function getData()
    {
        $fields = $this->model::getListFields();
        $list_fields = [];
        foreach ($fields as $field => $field_props) {
            $list_fields[] = $field;
        }

        $datatable = app('datatables')->of($this->model::query());

        // agregar la columna de acciones solo si puede editar o eliminar
        $permissions = $this->getPermissions();

        if ($this->hasActionsColumn()) {
            $datatable->addColumn('actions', function ($item) use ($permissions) {
                $actions = '<div class="btn-group btn-group-sm" role="group" aria-label="Actions">';

                if ($permissions['update'] == true || Sentinel::getUser()->inRole('superadmin')) {
                    $actions .= '<a href="' . route($this->edit_route, $item->id) . '" class="btn btn-warning"><i class="fa fa-pencil"></i> ' . trans('admin::admin.edit') . '</a>';
                }

                if ($permissions['delete'] == true || Sentinel::getUser()->inRole('superadmin')) {
                    $actions .= '<a href="' . route($this->delete_route, $item->id) . '" class="btn btn-danger" rel="delete"><i class="fa fa-trash"></i> ' . trans('admin::admin.delete') . '</a>';
                }

                $actions .= '</div>';

                return $actions;
            });
        }

        if ($this->hasTransformFields()) {
            $fields = $this->model::getTransformFields();
            foreach ($fields as $field => $props) {
                $datatable->editColumn($field, function ($item) use ($props) {
                    return call_user_func(array($this, $props['transform']), $item);
                });
            }
        }


        if ($this->hasActionsColumn()) {
            return $datatable->rawColumns(['actions'])->make(true);
        } else {
            return $datatable->make(true);
        }

    }

    private function hasTransformFields()
    {
        $fields = array_filter($this->model::getListFields(), function ($field) {
            return $field['transform'] !== false;
        });

        return count($fields) >= 0;
    }

    private function hasActionsColumn()
    {
        if(Sentinel::getUser()->inRole('superadmin')) {
            return true;
        }

        $permissions = $this->getPermissions();

        if ($permissions['update'] || $permissions['delete'] || $this->permissions_prefix == '') {
            return true;
        }

        return false;
    }

    protected function getValidationArray($fields)
    {
        $validation_fields = $this->model::getValidationFields($fields);
        $return_fields = [];

        foreach ($validation_fields as $field => $props) {
            $return_fields[$field] = $props['validation'];
        }

        return $return_fields;

    }
}