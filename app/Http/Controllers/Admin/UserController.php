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
        if ($this->checkPermission('user.view')) abort(404);

        $countAllUser = $userService->count();
        $countInactiveUser = $userService->count('inactive');
        $countActiveUser = $userService->count('active');
        $countBlockedUser = $userService->count('blocked');
        return view('admin.user.index', compact('countAllUser', 'countInactiveUser', 'countActiveUser', 'countBlockedUser'));
    }

    public function store(Request $request, UserService $userService)
    {
        if ($this->checkPermission('user.create')) return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat mengakses ini.']);

        $store = $userService->store($request);

        return response()->json($store);
    }

    public function show(Request $request, UserService $userService)
    {
        if ($this->checkPermission('user.view')) return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat mengakses ini.']);

        $show = $userService->show($request);

        return response()->json($show);
    }

    public function update(Request $request, UserService $userService)
    {
        if ($this->checkPermission('user.update')) return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat mengakses ini.']);

        $update = $userService->update($request);

        return response()->json($update);
    }

    public function destroy(Request $request, UserService $userService)
    {
        if ($this->checkPermission('user.delete')) return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat mengakses ini.']);

        $destroy = $userService->destroy($request);

        return response()->json($destroy);
    }

    public function showManage(Request $request, UserService $userService)
    {
        if ($this->checkPermission('user.manage')) return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat mengakses ini.']);

        $showManage = $userService->showManage($request);

        return response()->json($showManage);
    }

    public function manage(Request $request, UserService $userService)
    {
        if ($this->checkPermission('user.manage')) return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat mengakses ini.']);

        $manage = $userService->manage($request);

        return response()->json($manage);
    }

    public function getUsers(UserService $userService)
    {
        if ($this->checkPermission('user.view')) abort(404);

        $users = $userService->getAllUser();

        return DataTables::of($users)
            ->editColumn('name', function ($user) {
                $name = "<img src='" . asset('images/default.png') . "' data-original='" . $user->myPhoto() . "' alt='account-photo' title='account-photo' class='lazy mr-2 rounded-circle'>";
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

                if ($user->activation == 0) $activation .= "<a href='javascript:void(0)' class='action-icon'><i class='dripicons-cross text-danger'></i></a>";
                if ($user->activation == 1) $activation .= "<a href='javascript:void(0)' class='action-icon'><i class='dripicons-checkmark text-success'></i></a>";

                return $activation;
            })
            ->editColumn('phone_verification', function ($user) {
                $activation = "";

                if ($user->activation == 0) $activation .= "<a href='javascript:void(0)' class='action-icon'><i class='dripicons-cross text-danger'></i></a>";
                if ($user->activation == 1) $activation .= "<a href='javascript:void(0)' class='action-icon'><i class='dripicons-checkmark text-success'></i></a>";

                return $activation;
            })
            ->addColumn('role', function ($user) {
                $role = "";

                $role = '<span class="badge badge-secondary">' . ucfirst($user->roles->first()->name) . '</span>';

                if ($user->roles->first()->name == 'developer') $role = '<span class="badge badge-success">' . ucfirst($user->roles->first()->name) . '</span>';

                return $role;
            })
            ->addColumn('action', function ($user) {
                $action = "";

                if (!$this->checkPermission('user.manage')) $action .= "<a href='javascript:void(0)' class='action-icon' data-id='$user->id' onclick='getManageData(this)'><i class='mdi mdi-format-list-checks text-success'></i></a>";
                if (!$this->checkPermission('user.update')) $action .= "<a href='javascript:void(0)' class='action-icon' data-id='$user->id' onclick='getUpdateData(this)'><i class='mdi mdi-square-edit-outline text-info'></i></a>";
                if (!$this->checkPermission('user.delete')) $action .= "<a href='javascript:void(0)' class='action-icon' data-id='$user->id' onclick='deleteUser(this)'><i class='mdi mdi-delete text-danger'></i></a>";

                return $action;
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function checkusername(Request $request, UserService $userService)
    {
        $checkUsername = $userService->checkUnique($request);

        return response()->json($checkUsername);
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
