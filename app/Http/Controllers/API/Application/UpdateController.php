<?php

namespace App\Http\Controllers\API\Application;

use App\Enums\ApplicationStatusEnum;
use App\Helpers\ErrorFormatter;
use App\Http\Controllers\Controller;
use App\Traits\API\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
    use ResponserTrait;

    public function __construct(private \App\Repositories\ApplicationRepository $applicationRepository)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($id, Request $request)
    {
        $application = $this->applicationRepository->getById($id);

        if (!$application) {
            return $this->sendErrorData([], 'Request not found');
        }
        if ($application->status === ApplicationStatusEnum::Resolved) {
            return $this->sendErrorData([], "Request already resolved by moderator_id: {$application->moderator_id}");
        }

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            $errors = ErrorFormatter::format($validator->errors()->toArray());
            return $this->sendErrorData($errors, $validator->errors()->first());
        }

        $data = $request->only('comment');
        $data['status'] = ApplicationStatusEnum::Resolved;
        $data['moderator_id'] = auth()->user()->id;

        try {
//            $this->applicationRepository->updateModel($application, $data);

            // send email to user, that his request was resolved
            $user = $application->user;
            $user->notify(new \App\Notifications\ApplicationResolved($application));


            return $this->sendSuccessData([], 'Request status changed to Resolved');
        } catch (\Throwable $th) {
            var_dump($th->getFile());
            return $this->sendErrorData([], $th->getMessage());
        }
    }
}
