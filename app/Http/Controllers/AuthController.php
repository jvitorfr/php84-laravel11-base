<?php

namespace App\Http\Controllers;

use App\Http\Requests\{LoginUserRequest, RegisterUserRequest};
use Domain\User\{UseCase\Login\LoginUserParams,
    UseCase\Login\UserLoginUseCase,
    UseCase\Register\RegisterUserParams,
    UseCase\Register\RegisterUserUseCase
};
use Illuminate\Http\{JsonResponse};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

/**
 * @OA\Info(
 *     title="Laravel Swagger Base Project",
 *     version="1.0.0",
 *     description="Documentação da API do meu aplicativo"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="API Token"
 * )
 *
 * @OA\Tag(
 *     name="Auth Management",
 *     description="APIs relacionadas à autenticação de usuários"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="João Vitor Felipe"),
 *     @OA\Property(property="email", type="string", example="jvitorfr@outlook.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class AuthController extends BaseController
{
    public RegisterUserUseCase $registerUserUseCase;
    public UserLoginUseCase $userLoginUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase, UserLoginUseCase $userLoginUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->userLoginUseCase = $userLoginUseCase;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth Management"},
     *     summary="Registro de usuário.",
     *     description="Registro necessário para consumo de nossos serviços",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string", format="email"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="c_password", type="string"),
     *                 required={"name", "email", "password", "c_password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="User register successfully."),
     *     @OA\Response(response="400", description="Validation Error."),
     *     @OA\Response(response="500", description="Internal Server Error.")
     * )
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {

            $domainResponse = $this->registerUserUseCase->execute(new RegisterUserParams(
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            ));

            return $domainResponse->successResponse();
        } catch (ValidationException | InvalidArgumentException $exception) {
            return $this->sendError('Validation Error.', $exception->validator->errors(), 422);
        } catch (Throwable $throwable) {
            return $this->sendError('An error occurred while registering the user.', [$throwable->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth Management"},
     *     summary="Login de usuário",
     *     description="Autenticação necessária para consumo de nossos serviços",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="email", type="string", format="email"),
     *                 @OA\Property(property="password", type="string"),
     *                 required={"email", "password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="User login successfully."),
     *     @OA\Response(response="401", description="Não autenticado."),
     *     @OA\Response(response="500", description="Erro interno do servidor.")
     * )
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $domainResponse = $this->userLoginUseCase->execute(new LoginUserParams(
                $request->get('email'),
                $request->get('password')
            ));

            return $domainResponse->successResponse();
        } catch (ValidationException | InvalidArgumentException $exception) {
            return $this->sendError('Validation Error.', $exception->validator->errors(), 422);
        } catch (UnauthorizedHttpException $exception) {
            return $this->sendError($exception->getMessage(), [$exception->getMessage()], 401);
        } catch (Throwable $throwable) {
            return $this->sendError('An error occurred while trying to login.', [$throwable->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"Auth Management"},
     *     summary="Obter o usuário autenticado atual",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário recuperado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *     )
     * )
     */
    public function me(): JsonResponse
    {
        try {
            return $this->sendResponse([Auth::user()], "its you!!!");
        } catch (Throwable $throwable) {
            return $this->sendError('An error occurred while get logged user.', [$throwable->getMessage()], 500);
        }
    }

}
