<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\v1\CredentialsNotConfirmed;
use App\Exceptions\v1\CredentialsNotConfirmedException;
use App\Exceptions\v1\WrongRegisterCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ConfirmPhoneRequest;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kavenegar\KavenegarApi;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @throws CredentialsNotConfirmedException
     */
    public function login(LoginRequest $request,KavenegarApi $kavenegar)
    {
        $user = User::query()->where('username',$request->username)->first();
        if(Auth::attempt($request->all())){
            $token = $user->createToken($request->getClientIp())->plainTextToken;

            if($user->phone_verified_at == null){
                ConfirmSMS($user,$kavenegar);

                return response()->json([
                    'massage' => '.در انتظار تایید شماره تلفن' ,
                    'data'=>[
                        'token' => $token
                    ],
                    'status' => 406
                ],Response::HTTP_NOT_ACCEPTABLE);
            }

            return response()->json([
                'massage' => '.ورود با موفقیت انجام شد' ,
                'data'=>[
                    'token' => $token
                ],
                'status' => 200
            ],Response::HTTP_OK);
        }

    throw new CredentialsNotConfirmedException();
    }

    public function register(KavenegarApi $kavenegar,RegisterRequest $request)
    {
        $validData = $request->all();
        $validData['password'] = Hash::make($validData['password']);
        $user = User::query()->create($validData);
        $token = $user->createToken($request->getClientIp())->plainTextToken;
        ConfirmSMS($user,$kavenegar);
        return response()->json([
            'massage' => '.با موفقیت ساخته شد . در انتظار تایید شماره تلفن' ,
            'data'=>[
                'token' => $token
            ],
            'status' => 201
        ],Response::HTTP_CREATED);
    }

    /**
     * @throws WrongRegisterCodeException
     */
    public function confirmPhone(ConfirmPhoneRequest $request)
    {
        $code = auth()->user()->SMSs()->where('massage_type_id','1')->latest()->first()->code;
        if($code === $request['code']){
            $user = auth()->user();
            $user->update(['phone_verified_at' => now()]);
            return response()->json([
                'massage' => 'شماره تلفن همراه با موفقیت تایید شد' ,
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new WrongRegisterCodeException();
    }
}
