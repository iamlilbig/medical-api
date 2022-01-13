<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\v1\CredentialsNotConfirmed;
use App\Exceptions\v1\CredentialsNotConfirmedException;
use App\Exceptions\v1\TokenNotExistsException;
use App\Exceptions\v1\UserIsBanException;
use App\Exceptions\v1\UserNotExistsException;
use App\Exceptions\v1\WrongRegisterCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ConfirmPhoneRequest;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\RegisterRequest;
use App\Http\Requests\v1\UserRequest;
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
        $this->addWarning();
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
     * @throws UserIsBanException
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
        $this->addWarning();
        throw new WrongRegisterCodeException();
    }


    /**
     * @throws UserIsBanException
     */
    public function addWarning()
    {
        $warnings = auth()->user()->warning +1;
        if($warnings > 7){
            \auth()->user()->update([
                'warning' => 0,
                'banned_to' => now()->addDay()
            ]);
            throw new UserIsBanException();
        }
        \auth()->user()->update(['warning'=>$warnings]);
    }
    /**
     * @throws TokenNotExistsException
     */
    public function tokenDelete(Request $request)
    {
        $user = auth()->user();
        if($user->tokens()->delete()){
            $token = $user->createToken($request->getClientIp())->plainTextToken;
            return response()->json([
                'massage' => 'با موفقیت حذف شد.توکن جدید ارسال شد' ,
                'data'=>[
                    'token' => $token
                ],
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new TokenNotExistsException();
    }

    /**
     * @throws UserNotExistsException
     */
    public function destroy()
    {
        if(auth()->user()->delete()){
            return response()->json([
                'massage' => 'با موفقیت حذف شد',
                'status' => 200
            ], Response::HTTP_OK);
        }
        throw new UserNotExistsException();
    }

    /**
     * @throws UserNotExistsException
     */
    public function update(UserRequest $request)
    {
        $user = auth()->user()->first();
        if(!($user === null)){
            $validData = toSnakeCase($request->all());
            if(isset($validData['password'])){
                $validData['password'] = Hash::make($validData['password']);
            }
            $user->update($validData);
            return response()->json([
                'massage' => 'با موفقیت به روز شد' ,
                'data' => new \App\Http\Resources\v1\User($user),
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new UserNotExistsException();
    }

    public function show()
    {
        $user = auth()->user()->first();
        if(!($user === null)){
            return response()->json([
                'massage' => 'با موفقیت دریافت شد' ,
                'data' => new \App\Http\Resources\v1\User($user),
                'status' => 200
            ],Response::HTTP_OK);
        }
        throw new UserNotExistsException();
    }

}
