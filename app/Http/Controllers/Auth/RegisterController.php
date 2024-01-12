<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Laravel\Fortify\Http\Controllers\RegisteredUserController as FortifyRegisteredUserController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;


class RegisterController extends FortifyRegisteredUserController
{
    protected function create(Request $request)
    {
        // Add custom validation for the email domain
        Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                Rule::regex('/@acentriagroup\.com$/i')->message('The :attribute must be in the acentriagroup.com domain.'),
            ],
            // Other validation rules...
        ])->validate();

        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }
}
