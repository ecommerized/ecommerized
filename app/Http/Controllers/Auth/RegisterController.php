<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            "email" => ['required', 'email', 'max:255', 'unique:users'],
            "name" => ['required', 'string', 'max:255'],
            "password" => ['required', 'string', 'min:6'],
        ];

        if (getOption('register_file_required', 0)) {
            $rules['file'] = ['bail', 'required', 'mimetypes:application/pdf'];
        }

        if (!empty(getOption('google_recaptcha_status')) && getOption('google_recaptcha_status') == STATUS_ACTIVE) {
            $rules['g-recaptcha-response'] = 'required|recaptchav3:register';
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data )
    {
        try {
        DB::beginTransaction();
            $remember_token = Str::random(64);

            $google2fa = app('pragmarx.google2fa');

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => USER_ROLE_CLIENT,
                'remember_token' => $remember_token,
                'status' => USER_STATUS_ACTIVE,
                'verify_token' => str_replace('-', '', Str::uuid()->toString()),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ]);
            // notification call start
            $adminUser = User::where('role', USER_ROLE_ADMIN)->first();
            if ($adminUser) {
                setCommonNotification($adminUser->id, __('Have a new client'), __('Have a new client name '.$user->name), route('admin.client.list'));
            }

            DB::commit();

            return $user;
        }catch (\Exception $e){
            DB::rollBack();
            throw ValidationException::withMessages([
                'body' => [SOMETHING_WENT_WRONG],
            ]);
        }

    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
      return view('auth.register');
    }

}
