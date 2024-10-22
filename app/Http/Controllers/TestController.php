<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestController extends BaseController
{
    /**
     * @OA\PathItem(
     *     path="/api/test",
     *     @OA\Get(
     *         summary="mostra pros curiosos que o bagulho funciona",
     *         description="Retorna os dados em formato JSON.",
     *         @OA\Response(response="200", description="Dados retornados com sucesso")
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        $data = [
            'message' => 'Dados retornados com sucesso'
        ];

        return response()->json($data);
    }


    /**
     * @OA\PathItem(
     *     path="/api/test-pre-commit",
     *     @OA\Get(
     *         summary="está funcionando o pre commit",
     *         description="Retorna os dados em formato JSON.",
     *         @OA\Response(response="200", description="Dados retornados com sucesso")
     *     ),
     * )
     */
    public function testPreCommit(): JsonResponse
    {
        $data = [
            'message' => 'Dados retornados com sucesso'
        ];

        return response()->json($data);
    }
}
