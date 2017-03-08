<?php

namespace Modules\Admin\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\User;


class GenericAdminController extends Controller {

    protected $model = '';

    protected $index_template = '';
    protected $show_template = '';
    protected $edit_template = '';

    protected $permissions_prefix = '';

    protected $list_fields = [];


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {

        if ($request->ajax()) {
            return $this->getData();
        } else {
            $fields = $this->model::getListFields();

            // agregar la columna de acciones solo si puede editar o eliminar
            $permissions = $this->getPermissions();
            if($permissions['update'] || $permissions['delete']) {
                $fields[] = ['label' => 'Actions'];
            }

            return view($this->index_template, [
                'fields' => $fields
            ]);
        }


    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
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
    public function show(Request $request) {
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
    public function edit($id) {
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
    public function update(Request $request, $id) {

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy() {
    }

    private function getPermissions() {
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

    private function getData() {
        $fields = $this->model::getListFields();
        $list_fields = [];
        foreach($fields as $field => $field_props){
            $list_fields[] = $field;
        }

        $items = $this->model::select($list_fields);

        $datatable = app('datatables')->of($items);

        // agregar la columna de acciones solo si puede editar o eliminar
        $permissions = $this->getPermissions();

        if($permissions['update'] || $permissions['delete'] || $this->permissions_prefix == '') {
            $datatable->addColumn('actions', function($item) use($permissions) {
                $actions = '<div class="btn-group pull-right btn-group-sm" role="group" aria-label="Actions">';

                if($permissions['update'] == true) {
                    $actions .= '<a href="edit" class="btn btn-warning" target="_blank"><i class="fa fa-pencil"></i>Ver</a>';
                }

                if($permissions['delete'] == true) {
                    $actions .= '<a href="delete" class="btn btn-error" target="_blank"><i class="fa fa-trash"></i>Ver</a>';
                }

                $actions .= '</div>';

                return $actions;
            });
        }



        return $datatable->make(true);
    }
}