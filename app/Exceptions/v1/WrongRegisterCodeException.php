<?php

namespace App\Exceptions\v1;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WrongRegisterCodeException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json(
            [
                'massage' => 'کد صحیح نمیباشد',
                'status' => 422,
            ],Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
