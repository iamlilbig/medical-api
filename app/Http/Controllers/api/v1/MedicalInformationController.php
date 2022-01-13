<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\v1\MedicalInformationExistsException;
use App\Exceptions\v1\MedicalInformationNotExistsException;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MedicalInformationRequest;
use App\Http\Resources\v1\MedicalInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicalInformationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MedicalInformationRequest $request
     * @return JsonResponse
     * @throws MedicalInformationExistsException
     */
    public function store(MedicalInformationRequest $request)
    {
        if(auth()->user()->medicalInformation()->first() === null){
            $validData = Helpers::toSnakeCase($request->all());
            $validData['user_id'] = auth()->user()->id;
            $medicalInformation = auth()->user()->medicalInformation()->create($validData);

            return response()->json([
                'massage' => 'با موفقیت اضافه شد' ,
                'data' => new MedicalInformation($medicalInformation),
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new MedicalInformationExistsException();
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws MedicalInformationNotExistsException
     */
    public function show()
    {
        if(!(auth()->user()->medicalInformation()->first() === null)){
            return response()->json([
            'massage' => 'با موفقیت دریافت شد' ,
            'data' => new MedicalInformation(auth()->user()->medicalInformation()->first()),
            'status' => 200
        ],Response::HTTP_OK);
        }
        throw new MedicalInformationNotExistsException();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MedicalInformationRequest $request
     * @return JsonResponse
     * @throws MedicalInformationNotExistsException
     */
    public function update(MedicalInformationRequest $request)
    {
        if(!(auth()->user()->medicalInformation()->first() === null)){
            $validData = Helpers::toSnakeCase($request->all());
            auth()->user()->medicalInformation()->update($validData);
            return response()->json([
                'massage' => 'با موفقیت به روز شد' ,
                'data' => new MedicalInformation(auth()->user()->medicalInformation()->first()),
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new MedicalInformationNotExistsException();
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param int $id
     * @return JsonResponse
     * @throws MedicalInformationNotExistsException
     */
    public function destroy()
    {
        if(!(auth()->user()->medicalInformation()->first() === null)) {
            auth()->user()->medicalInformation()->delete();
            return response()->json([
                'massage' => 'با موفقیت حذف شد' ,
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new MedicalInformationNotExistsException();
    }
}
