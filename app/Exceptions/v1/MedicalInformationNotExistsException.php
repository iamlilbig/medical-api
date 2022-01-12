<?php

namespace App\Exceptions\v1;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicalInformationNotExistsException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render($request)
    {
        return response()->json(
            [
                'massage' => 'اطلاعات پزشکی وجود ندارد',
                'status' => 422,
            ],Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
