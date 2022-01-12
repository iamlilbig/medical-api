<?php

namespace App\Exceptions\v1;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class MedicalInformationExistsException extends Exception
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
                'massage' => 'اطلاعات پزشکی وجود دارد',
                'status' => 422,
            ],Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
