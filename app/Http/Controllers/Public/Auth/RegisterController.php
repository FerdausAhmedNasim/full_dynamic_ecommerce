<?php

namespace App\Http\Controllers\Public\Auth;

use App\Http\Controllers\Controller;
use App\Library\Enum;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function showRegistrationForm()
    {
        return view('public.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $custom_validation_messages = [
            'first_name.required' => "First Name is required",
            'first_name.max'      => "First Name not be gater than 25 characters.",

            'last_name.required' => "Last Name is required",
            'last_name.max'      => "Last Name can not be gater than 25 characters.",

            'phone.min'      => "phone can not be less than 11 characters.",
            'phone.max'      => "phone can not be gater than 14 characters.",
            'phone.required' => "phone is required",
            'phone.unique'   => "phone number already Registered",

            'password.required' => "Password is required",
            'password.min'      => "Password can not be less than 8 characters.",
        ];

        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:25'],
            'last_name'  => ['required', 'string', 'max:25'],
            'phone'      => ['required', 'string', 'max:14', 'min:11', 'unique:users,phone'],
            'password'   => ['required', 'string', 'min:8'],
        ], $custom_validation_messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
            'password'   => Hash::make($data['password']),
            'user_type'  => Enum::USER_TYPE_CUSTOMER,
            'status'     => Enum::USER_STATUS_ACTIVE,

        ]);
    }
}
