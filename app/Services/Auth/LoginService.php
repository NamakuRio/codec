<?php

namespace App\Services\Auth;

use App\Events\UserLoginEvent;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginService
{
    use ThrottlesLogins;

    public function web(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return ['status' => 'warning', 'message' => $validator->errors()->first()];
        }

        DB::beginTransaction();
        try {
            if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
                DB::rollback();
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                $request->session()->regenerate();

                $this->clearLoginAttempts($request);

                $status_user = $this->checkStatusUser();
                if ($status_user['status'] != 'success') {
                    DB::rollback();

                    $this->guard()->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return $status_user;
                }

                $user = auth()->user();

                event(new UserLoginEvent($user));

                $login_destination = $user->roles->first()->login_destination;

                DB::commit();
                return ['status' => 'success', 'message' => 'Berhasil masuk.', 'login_destination' => $login_destination];
            }

            $this->incrementLoginAttempts($request);

            DB::rollback();
            return ['status' => 'error', 'message' => 'Nama Pengguna atau Kata Sandi yang Anda masukkan salah.'];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function username()
    {
        return 'username';
    }

    public function checkStatusUser()
    {
        $user = auth()->user();
        $return = [];

        switch ($user->status) {
            case 0:
                $return =  ['status' => 'warning', 'message' => 'Akun Anda belum aktif.'];
                break;
            case 1:
                $return =  ['status' => 'success', 'message' => 'Anda dapat masuk.'];
                break;
            case 2:
                $return =  ['status' => 'error', 'message' => 'Akun anda diblokir.'];
                break;
            default:
                $return =  ['status' => 'error', 'message' => 'Status Anda tidak terdaftar.'];
        }

        return $return;
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only('username', 'password');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function validator(array $data, $type = 'web')
    {
        if ($type == 'web') {
            $rules = [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ];

            $messages = [
                'required' => ':attribute tidak boleh kosong',
                'string' => ':attribute harus berupa String'
            ];
        } else {
            $rules = [];
            $messages = [];
        }

        return Validator::make($data, $rules, $messages);
    }
}
