<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index');
    }

    public function getRoles(RoleService $roleService)
    {
        $roles = $roleService->getAllRole();

        return DataTables::of($roles)
                ->editColumn('default_user', function($role) {
                    $default_user = "";

                    if($role->default_user == 0) $default_user .= "<i class='dripicons-cross text-danger'></span>";
                    if($role->default_user == 1) $default_user .= "<i class='dripicons-checkmark text-success'></span>";

                    return $default_user;
                })
                ->editColumn('login_destination', function($role) {
                    $login_destination = url('/');

                    $login_destination .= "<span class='text-primary'>/$role->login_destination</span>";

                    return $login_destination;
                })
                ->addColumn('action', function($role) {
                    $action = "";

                    $action .= "<a href='javascript:void(0)' class='action-icon'><i class='mdi mdi-square-edit-outline'></i></a>";
                    $action .= "<a href='javascript:void(0)' class='action-icon'><i class='mdi mdi-delete'></i></a>";

                    return $action;
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }
}
