<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\v1\MedicalInformationExistsException;
use App\Exceptions\v1\MedicalInformationNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MedicalInformationRequest;
use App\Http\Resources\v1\MedicalInformation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicalInformationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MedicalInformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws MedicalInformationExistsException
     */
    public function store(MedicalInformationRequest $request)
    {
        if(auth()->user()->medicalInformation()->first() === null){
            $validData = toSnakeCase($request->all());
            $validData['user_id'] = auth()->user()->id;
            auth()->user()->medicalInformation()->create($validData);

            return response()->json([
                'massage' => 'با موفقیت اضافه شد' ,
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new MedicalInformationExistsException();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json([
            'massage' => 'با موفقیت دریافت شد' ,
            'data' => new MedicalInformation(auth()->user()->medicalInformation()->first()),
            'status' => 200
        ],Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MedicalInformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws MedicalInformationNotExistsException
     */
    public function update(MedicalInformationRequest $request)
    {
        if(!(auth()->user()->medicalInformation()->first() === null)){
            $validData = toSnakeCase($request->all());
            $validData['user_id'] = auth()->user()->id;
            auth()->user()->medicalInformation()->update($validData);

            return response()->json([
                'massage' => 'با موفقیت به روز شد' ,
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new MedicalInformationNotExistsException();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        auth()->user()->medicalInformation()->delete();
        return response()->json([
            'massage' => 'با موفقیت حذف شد' ,
            'status' => 200
        ],Response::HTTP_OK);
    }
}
