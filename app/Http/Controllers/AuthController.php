<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * @OA\PathItem(
     *     path="/register",
     *     @OA\Post(
     *         summary="Registro de usuário",
     *         description="Registro necessária para consumo de nossos serviços",
     *         @OA\Response(response="200", description="User register successfully.")
     *     ),
     * )
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('LaravelApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * @OA\PathItem(
     *     path="/login",
     *     @OA\Post(
     *         summary="Login de usuário",
     *         description="autenticação necessária para consumo de nossos serviços",
     *         @OA\Response(response="200", description="User login successfully.")
     *     ),
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
        /** @var User $user */
        $user = Auth::user();
        $success['token'] = $user->createToken('LaravelApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User login successfully.');

    }
}
