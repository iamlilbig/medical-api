<?php

namespace App\Exceptions\v1;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AttendantNotExistsException extends Exception
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
                'massage' => 'همراه وجود ندارد',
                'status' => 422,
            ],Response:: HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
