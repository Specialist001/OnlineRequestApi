<?php

namespace App\Http\Controllers\API\Application;

use App\Helpers\ErrorFormatter;
use App\Http\Controllers\Controller;
use App\Traits\API\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    use ResponserTrait;

    public function __construct(private \App\Repositories\ApplicationRepository $applicationRepository)
    {
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'message' => 'required|string|min:5|max:1000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = ErrorFormatter::format($validator->errors()->toArray());
            return $this->sendErrorData($errors, $validator->errors()->first());
        }

        $data = $request->only('message');

        $user = auth()->user();
        $data['user_id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        if (!$this->applicationRepository->userCanCreateApplication($data['user_id'], 3)) {
            return $this->sendErrorData([], "You already have an active request. Wait 3 minutes to submit a request again or wait for a moderator to resolve the problem.");
        }

        try {
            $this->applicationRepository->create($data);
            return $this->sendSuccessData([], 'Request created, wait for moderator response');
        } catch (\Throwable $th) {
            return $this->sendErrorData([], $th->getMessage());
        }
    }
}
