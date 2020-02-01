<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(UserService $userService)
    {
        $countAllUser = $userService->count();
        $countInactiveUser = $userService->count('inactive');
        $countActiveUser = $userService->count('active');
        $countBlockedUser = $userService->count('blocked');
        return view('admin.user.index', compact('countAllUser', 'countInactiveUser', 'countActiveUser', 'countBlockedUser'));
    }

    public function getUsers(UserService $userService)
    {
        $users = $userService->getAllUser();

        return DataTables::of($users)
            ->editColumn('name', function ($user) {
                $name = "<img src='".asset('images/default.png')."' data-original='" . $user->myPhoto() . "' alt='account-photo' title='account-photo' class='lazy mr-2 rounded-circle'>";
                $name .= "<a href='javascript:void(0)' class='text-body font-weight-semibold'>$user->name</a>";

                return $name;
            })
            ->editColumn('status', function ($user) {
                $status = "";

                if ($user->status == 0) $status .= "<span class='badge bg-soft-warning text-warning'>Belum Aktif</span>";
                if ($user->status == 1) $status .= "<span class='badge bg-soft-success text-success'>Aktif</span>";
                if ($user->status == 2) $status .= "<span class='badge bg-soft-danger text-danger'>Diblokir</span>";

                return $status;
            })
            ->editColumn('activation', function ($user) {
                $activation = "";

                if ($user->activation == 0) $activation .= "<i class='dripicons-cross text-danger'></span>";
                if ($user->activation == 1) $activation .= "<i class='dripicons-checkmark text-success'></span>";

                return $activation;
            })
            ->editColumn('phone_verification', function ($user) {
                $activation = "";

                if ($user->activation == 0) $activation .= "<i class='dripicons-cross text-danger'></span>";
                if ($user->activation == 1) $activation .= "<i class='dripicons-checkmark text-success'></span>";

                return $activation;
            })
            ->addColumn('action', function ($user) {
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
