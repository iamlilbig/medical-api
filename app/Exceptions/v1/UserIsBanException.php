<?php

namespace App\Exceptions\v1;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserIsBanException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        $banTime = auth()->user()->banned_to;
        return response()->json(
            [
                'massage' => 'کاربر مسدود شده است',
                'data' => [
                    'banned_to' => $banTime
                ],
                'status' => 403,
            ],Response::HTTP_FORBIDDEN
        );
    }
}
