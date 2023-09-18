<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;

class LogOutController extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully.',
        ]);
    }
}
