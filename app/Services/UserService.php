<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function getAllUser()
    {
        $users = User::all();

        return $users;
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return ['status' => 'warning', 'message' => $validator->errors()->first()];
        }

        DB::beginTransaction();
        try {
            $data = [
                'username' => $request->username,
                'name' => $request->name,
                'email' => $this->checkEmail($request->email),
                'password' => bcrypt($request->password),
                'phone' => $this->checkPhone($request->phone),
            ];

            $user = User::create($data);

            $role = Role::find($request->role);
            if (!$role) {
                DB::rollback();
                return ['status' => 'error', 'message' => 'Peran tidak ditemukan.'];
            }

            $user->assignRole($role->name);

            DB::commit();
            return ['status' => 'success', 'message' => 'Berhasil menambahkan pengguna.'];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);

        if (!$user) {
            return ['status' => 'error', 'message' => 'Pengguna yang Anda cari tidak ditemukan.', 'data' => ''];
        }

        return ['status' => 'success', 'message' => 'Berhasil mengambil data Pengguna', 'data' => $user, 'role' => $user->roles->first()];
    }

    public function update(Request $request)
    {
        $validator = $this->validator($request->all(), 'update', $request->id);
        if ($validator->fails()) {
            return ['status' => 'warning', 'message' => $validator->errors()->first()];
        }

        DB::beginTransaction();
        try {
            $data = [
                'username' => $request->username,
                'name' => $request->name,
                'email' => $this->checkEmail($request->email),
                'phone' => $this->checkPhone($request->phone),
            ];

            if (isset($request->password)) {
                if ($request->password != $request->confirmation_password) {
                    DB::rollback();
                    return ['status' => 'error', 'message' => 'Kata sandi yang dimasukkan tidak sama.'];
                }
                $data['password'] = bcrypt($request->password);
            }

            $user = User::find($request->id);
            $user->update($data);

            if (!$user) {
                DB::rollback();
                return ['status' => 'error', 'message' => 'Gagal memperbarui pengguna.'];
            }

            $role = Role::find($request->role);
            if (!$role) {
                DB::rollback();
                return ['status' => 'error', 'message' => 'Peran tidak ditemukan.'];
            }

            $user->syncRoles($role->name);

            DB::commit();
            return ['status' => 'success', 'message' => 'Berhasil memperbarui pengguna.'];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->id);

            if (!$user) {
                DB::rollback();
                return ['status' => 'error', 'message' => 'Pengguna tidak ditemukan.'];
            }

            $user->delete();

            DB::commit();
            return ['status' => 'success', 'message' => 'Berhasil menghapus pengguna.'];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function showManage(Request $request)
    {
        $permissions = Permission::all();
        $user = User::find($request->id);
        $view = "";

        $user_permissions = $this->get_user_permission($user->id);
        $role_permissions = $this->get_role_permission($user->roles->first()->id);

        $no = 1;
        $rows = array();
        $header = array();
        $tmp = array();

        foreach ($permissions as $permission) {
            $x = explode(".", $permission->name);
            if (!in_array($x[1], $header)) {
                $header[] = $x[1];
                $tmp[$x[1]] = 0;
            }
        }

        foreach ($permissions as $permission) {
            $x = explode(".", $permission->name);
            $rows[$x[0]] = $tmp;
        }

        foreach ($permissions as $key => $permission) {
            $x = explode(".", $permission->name);
            //Rows
            $rows[$x[0]][$x[1]] = array('id' => $permission->id, 'action_name' => $x[1], 'is_role_permission' => (isset($role_permissions[$permission->id]->is_role_permission) && $role_permissions[$permission->id]->is_role_permission == 1) ? 1 : '', 'is_user_permission' => (isset($user_permissions[$permission->id]->is_user_permission) && $user_permissions[$permission->id]->is_user_permission == 1) ? 1 : '', 'value' => (isset($user_permissions[$permission->id]) ? 1 : 0));
        }

        $view .= '<input type="hidden" id="manage-user-id" name="id" value="' . $user->id . '" required>';
        $view .= '<div class="table-responsive">';

        $view .= '<table class="table table-bordered table-hover text-center">';

        $view .= '<thead>';
        $view .= '<tr>';
        $view .= '<td>#</td>';
        $view .= '<td>Izin</td>';
        foreach ($header as $hd) {
            $view .= '<td>' . ucfirst($hd) . '</td>';
        }
        $view .= '</tr>';
        $view .= '</thead>';

        $view .= '<tbody>';
        foreach ($rows as $key => $row) {
            $view .= '<tr>';
            $view .= '<td>' . $no++ . '</td>';
            $view .= '<td>' . $key . '</td>';
            foreach ($row as $action) {
                $view .= '<td>';
                if ($action == 0) {
                    $view .= '-';
                } else {
                    $checked = '';
                    $role_checked = '';
                    $set_disabled = '';
                    $name_input = 'name="permission[]"';

                    if ($action['value'] == 1) $checked = 'checked';
                    if ($action['is_role_permission'] == 1) {
                        $checked = 'checked';
                        $role_checked = 'Role';
                        $set_disabled = 'disabled';
                        $name_input = '';
                    }

                    $view .= '<div class="custom-control custom-switch">';
                    $view .= '<input type="checkbox" class="custom-control-input" ' . $name_input . ' value="' . $action['id'] . '" id="customSwitch' . $action['id'] . '" ' . $set_disabled . ' ' . $checked . '>';
                    $view .= '<label class="custom-control-label" for="customSwitch' . $action['id'] . '">' . $role_checked . '</label>';
                    $view .= '</div>';
                }
                $view .= '</td>';
            }
            $view .= '</tr>';
        }
        $view .= '</tbody>';

        $view .= '</table>';

        $view .= '</div>';

        return ['status' => 'success', 'message' => 'Berhasil mengambil data Manage Pengguna', 'data' => $view];
    }

    public function manage(Request $request)
    {
        DB::beginTransaction();
        try {
            $permissions = $request->permission;
            $user = User::find($request->id);

            if (empty($permissions)) {
                $user->permissions()->detach();

                DB::commit();
                return ['status' => 'success', 'message' => 'Berhasil mengubah data izin pengguna.'];
            }

            for ($i = 0; $i < count($permissions); $i++) {
                $perms[] = Permission::find($permissions[$i]);
            }

            foreach ($perms as $perm) {
                $data[] = $perm->name;
            }

            if (!empty($user)) {
                $user->updatePermissions($data);
            }

            DB::commit();
            return ['status' => 'success', 'message' => 'Berhasil mengubah data izin pengguna.'];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function count($type = 'all')
    {
        $users = new User;
        if ($type == 'all') {
            $count = $users->get()->count();
        } else if ($type == 'inactive') {
            $count = $users->where('status', 0)->get()->count();
        } else if ($type == 'active') {
            $count = $users->where('status', 1)->get()->count();
        } else if ($type == 'blocked') {
            $count = $users->where('status', 2)->get()->count();
        }

        return $count;
    }

    public function checkUnique(Request $request)
    {
        $username = $request->username;
        $type = $request->type;
        $id = $request->id;

        if ($type == 'insert') {
            $user = User::where('username', $username)->count();

            if (!$user == 0) {
                return ['status' => 'error', 'message' => 'Nama Pengguna Tidak Tersedia.'];
            }

            $response = ['status' => 'success', 'message' => 'Nama Pengguna Tersedia.'];
        } else if ($type == 'update') {
            $user = User::find($id);

            if ($user->username == $username) {
                return ['status' => 'success', 'message' => 'Nama Pengguna Tersedia.'];
            }

            $userCheck = User::where('username', $username)->count();

            if (!$userCheck == 0) {
                return ['status' => 'error', 'message' => 'Nama Pengguna Tidak Tersedia.'];
            }

            $response = ['status' => 'success', 'message' => 'Nama Pengguna Tersedia.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Tidak ada tindakan yang dilakukan.'];
        }

        return $response;
    }

    protected function validator(array $data, $type = 'insert', $id = 0)
    {
        $data['email'] = $this->checkEmail($data['email']);
        $data['phone'] = $this->checkPhone($data['phone']);

        $rules_username = "";
        $rules_email = "";
        $rules_phone = "";
        $rules_password = "";
        if ($type == 'insert') {
            $rules_username = 'unique:users,username';
            $rules_email = 'unique:users,email';
            $rules_phone = 'unique:users,phone';
            $rules_password = ['required', 'string'];
        } else if ($type == 'update') {
            $rules_username = 'unique:users,username,' . $id;
            $rules_email = 'unique:users,email,' . $id;
            $rules_phone = 'unique:users,phone,' . $id;
            $rules_password = '';
        }

        $rules = [
            'role' => ['required'],
            'username' => ['required', 'string', 'max:191', $rules_username],
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'max:191', 'email', $rules_email],
            'password' => ['max:191', $rules_password],
            'phone' => ['required', 'numeric', $rules_phone],
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'string' => ':attribute harus berupa string',
            'max' => ':attribute maksimal :max karakter',
            'unique' => ':attribute yang Anda masukkan sudah terdaftar',
            'email' => ':attribute harus berupa email',
            'numeric' => ':attribute harus berupa angka',
        ];

        return Validator::make($data, $rules, $messages);
    }

    protected function get_user_permission($id)
    {
        $user = User::find($id);

        $permissions = $user->permissions;

        $merge = array();

        if ($permissions) {
            foreach ($permissions as $permission) {
                $permission->is_user_permission = 1;
                $merge[$permission->id] = $permission;
            }
        }

        return $merge;
    }

    protected function get_role_permission($id)
    {
        $role = Role::find($id);

        $permissions = $role->permissions;

        $merge = array();

        if ($permissions) {
            foreach ($permissions as $permission) {
                $permission->is_role_permission = 1;
                $merge[$permission->id] = $permission;
            }
        }

        return $merge;
    }

    protected function checkPhone($phone)
    {
        $phone_dot = str_replace('.', '', $phone);
        $phone_space = str_replace(' ', '', $phone_dot);
        $phone_id = $phone_space[0] . $phone_space[1];
        $phone_id_2 = $phone_space[0] . $phone_space[1] . $phone_space[2];

        if ($phone_id == "08") {
            $phone_space = '628' . substr($phone_space, 2);
        }

        if ($phone_id_2 == "+62") {
            $phone_space = '628' . substr($phone_space, 3);
        }

        return $phone_space;
    }

    protected function checkEmail($email)
    {
        list($username, $domain) = explode('@', $email);

        if ($domain == 'gmail.com') {
            $username = str_replace('.', '', $username);

            $email = $username . "@" . $domain;
        }

        return $email;
    }
}
