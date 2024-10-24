<?php

namespace App\Http\Controllers;

use Domain\Contracts\Repositories\IUserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{JsonResponse, Request};
use Throwable;

/**
 *
 * @OA\Tag(
 *     name="Users",
 *     description="APIs relacionado a usuários"
 * )
 *
 */
class UserController extends BaseController
{
    public IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Obter todos",
     *     security={{"bearerAuth": {}}},
     *     description="Obter todos",
     *     @OA\Response(
     *         response=200,
     *         description="Consulta realizada com sucesso.",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *     )
     * )
     */
    public function index()
    {
        return $this->sendResponse($this->userRepository->all()->toArray(), "Consulta realizada.");
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Criação de usuário",
     *     security={{"bearerAuth": {}}},
     *     description="Registro de usuário por Usuário logado.",
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
    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse($this->userRepository->create($request->all())->toArray(), 'Criação realizada.');
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Obter o objeto por Id",
     *     security={{"bearerAuth": {}}},
     *     description="Obter um usuário pelo Id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consulta realizada com sucesso.",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *     )
     * )
     */

    public function show(string $id): JsonResponse
    {
        return $this->sendResponse($this->userRepository->find($id)->toArray(), 'Consulta realizada.');
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Atualizar o objeto por Id",
     *     security={{"bearerAuth": {}}},
     *     description="Atualizar um usuário pelo Id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados para atualização",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="John Doe"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="johndoe@example.com"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Atualização realizada com sucesso.",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *     )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return $this->sendResponse($this->userRepository->update($id, $request->all())->toArray(), 'Atualização realizada.');
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Deleta o usuário por Id",
     *     security={{"bearerAuth": {}}},
     *     description="Deleta o usuário correspondente ao Id fornecido",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário a ser deletado",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Remoção realizada com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Usuário deletado com sucesso"),
     *             @OA\Property(property="success", type="boolean", example="true")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="ID inválido",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="ID inválido fornecido"),
     *             @OA\Property(property="success", type="boolean", example="false")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Não autenticado"),
     *             @OA\Property(property="success", type="boolean", example="false")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sem permissão para deletar o usuário",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Acesso negado"),
     *             @OA\Property(property="success", type="boolean", example="false")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Usuário não encontrado"),
     *             @OA\Property(property="success", type="boolean", example="false")
     *         )
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if (strlen($id) > 11) {
                throw new Exception("ID inválido", 400);
            }

            $this->userRepository->delete($id);

            return $this->sendResponse([], 'Remoção Concluída.');
        } catch (ModelNotFoundException $exception) {
            return $this->sendError("Usuário não encontrado");
        } catch (Throwable $exception) {
            return $this->sendError($exception->getMessage());
        }
    }
}
