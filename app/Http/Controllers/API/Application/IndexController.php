<?php

namespace App\Http\Controllers\API\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Traits\API\ResponserTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use ResponserTrait;

    public function __construct(public \App\Repositories\ApplicationRepository $applicationRepository)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $filter = new \App\Filters\ApplicationFilter($request);

        $query = Application::filter($filter);

        $applications = $query->paginateFilter($request->input('per_page', 15))
            ->withQueryString()
            ->through(fn ($application) => [
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
            ]);

        $items = $applications->items();

        $pagination_data = $this->makePaginationData($applications);

        return $this->sendSuccessData($items, 'Applications list', $pagination_data);
    }
}
