<?php

namespace App\Exceptions\v1;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PhoneNotConfirmedException extends Exception
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
                'massage' => 'تلفن تایید نشده',
                'status' => 403,
            ],Response:: HTTP_FORBIDDEN
        );
    }
}
