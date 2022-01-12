<?php

namespace App\Exceptions\v1;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TokenNotExistsException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json(
            [
                'massage' => 'توکن برای این کاربر ثبت نشده',
                'status' => 404,
            ],Response::HTTP_NOT_FOUND
        );
    }
}
