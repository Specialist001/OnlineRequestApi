<?php

namespace App\Traits\API;

trait ResponserTrait
{
    public function sendSuccessData($result, string $message = "", $pagination = null, int $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            'pagination_data' => $pagination,
        ];


        return response()->json($response, $code);
    }

    public function sendErrorData(array $errors = [], string $message = "", int $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $code);
    }

    public function makePaginationData($paginator)
    {
        return [
            'current_page' => $paginator->currentPage(),
            'first_page_url' => $paginator->url(1),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'last_page_url' => $paginator->url($paginator->lastPage()),
            'next_page_url' => $paginator->nextPageUrl(),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];
    }

}
