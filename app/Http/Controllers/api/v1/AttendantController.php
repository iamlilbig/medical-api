<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\v1\AttendantExistsException;
use App\Exceptions\v1\AttendantNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AttendantsRequest;
use App\Http\Requests\v1\SMSRequest;
use App\Http\Resources\v1\Attendant;
use App\Http\Resources\v1\MedicalInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kavenegar\KavenegarApi;
use Symfony\Component\HttpFoundation\Response;

class AttendantController extends Controller
{

    /**
     * @throws AttendantNotExistsException
     */
    public function sendSMS(SMSRequest $request, $id, KavenegarApi $kavenegar)
    {
        $user = auth()->user();
        $attendant = $user->attendants()->find($id);
        if($user->attendants()->find($id) != null){
            sendSMS($user,$attendant,$request->text,$kavenegar);
            return response()->json([
                'massage' => 'با موفقیت ارسال شد',
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new AttendantNotExistsException();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     * @throws AttendantExistsException
     */
    public function store(AttendantsRequest $request)
    {
        $user = auth()->user()->attendants();
        if(! $user->where('phone',$request->phone)->where('name',$request->name)->exists()){
            $attendant = $user->create($request->all());

            return response()->json([
                'massage' => 'با موفقیت اضافه شد' ,
                'data' => new Attendant($attendant),
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new AttendantExistsException();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttendantsRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AttendantNotExistsException
     */
    public function update(AttendantsRequest $request, $id)
    {
        $user = auth()->user()->attendants()->find($id);
        if($user != null){
            $attendant = $user->update($request->all());

            return response()->json([
                'massage' => 'با موفقیت به روز شد' ,
                'data' => new Attendant(auth()->user()->attendants()->find($id)),
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new AttendantNotExistsException();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AttendantNotExistsException
     */
    public function destroy($id)
    {
        $user = auth()->user()->attendants()->find($id);
        if($user != null){
            $attendant = $user->delete();

            return response()->json([
                'massage' => 'با موفقیت حذف شد' ,
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new AttendantNotExistsException();
    }
}
