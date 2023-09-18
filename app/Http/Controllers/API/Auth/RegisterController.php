<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ErrorFormatter;
use App\Traits\API\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends \App\Http\Controllers\Controller
{
    use ResponserTrait;
    public function __construct(public \App\Repositories\UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = ErrorFormatter::format($validator->errors()->toArray());
            return $this->sendErrorData($errors, 'User register failed.', 401);
        }

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        if ($user) {
            $token = $this->userRepository->createApiAuthToken($user);

            return $this->sendSuccessData(['token' => $token], 'User registered successfully.');
        }

        return $this->sendErrorData([], 'User registration failed.', 401);
    }
}
