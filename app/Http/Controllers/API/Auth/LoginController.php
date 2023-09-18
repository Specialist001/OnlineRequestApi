<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ErrorFormatter;
use App\Repositories\UserRepository;
use App\Traits\API\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends \App\Http\Controllers\Controller
{
    use ResponserTrait;

    public function __construct(public UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = ErrorFormatter::format($validator->errors()->toArray());
            return $this->sendErrorData($errors, 'User login failed.', 401);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $this->userRepository->createApiAuthToken($user);

            return $this->sendSuccessData(['token' => $token], 'User login successfully.');
        }


        return $this->sendErrorData([], 'Incorrect email or password.', 401);
    }
}
