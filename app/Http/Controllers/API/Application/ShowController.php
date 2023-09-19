<?php

namespace App\Http\Controllers\API\Application;

use App\Http\Controllers\Controller;
use App\Traits\API\ResponserTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowController extends Controller
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

        $data = [
            'id' => $application->id,
            'name' => $application->name,
            'email' => $application->email,
            'message' => $application->message,
            'status' => $application->status,
            'comment' => $application->comment,
            'user_id' => $application->user_id,
            'moderator_id' => $application->moderator_id,
            'created_at' => $application->created_at ? Carbon::make($application->created_at)->format('Y-m-d H:i:s') : null,
            'updated_at' => $application->updated_at ? Carbon::make($application->updated_at)->format('Y-m-d H:i:s') : null,
        ];

        return $this->sendSuccessData($data, 'Request');
    }
}
