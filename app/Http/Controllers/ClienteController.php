<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Api para Viamatica", version="0.1")
 */
class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientes",
     *     summary="Obtiene la lista de clientes",
     *     tags={"Clientes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Cliente"))
     *     )
     * )
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * @OA\Post(
     *     path="/api/clientes",
     *     summary="Crea un nuevo cliente",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         description="Datos del cliente",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente creado",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $cliente = Cliente::create($request->all());
        return response()->json($cliente, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/{id}",
     *     summary="Obtiene un cliente por ID",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del cliente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     )
     * )
     */
    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    /**
     * @OA\Put(
     *     path="/api/clientes/{id}",
     *     summary="Actualiza un cliente por ID",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del cliente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Datos del cliente",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     )
     * )
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all());
        return response()->json($cliente);
    }

    /**
     * @OA\Delete(
     *     path="/api/clientes/{id}",
     *     summary="Elimina un cliente por ID",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del cliente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente eliminado",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     )
     * )
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
}
