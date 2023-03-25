<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ordens",
     *     summary="Obtiene la lista de órdenes",
     *     tags={"Ordenes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de órdenes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Orden"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Orden::query();

        if ($request->has('fechaDesde') && $request->has('fechaHasta')) {
            $query->whereBetween('created_at', [$request->fechaDesde, $request->fechaHasta]);
        }

        if ($request->has('idEstadoOrden')) {
            $query->where('id_estado_orden', $request->idEstadoOrden);
        }

        $ordens = $query->get();
        return response()->json($ordens);
    }

    /**
     * @OA\Post(
     *     path="/api/ordens",
     *     summary="Crea una nueva orden",
     *     tags={"Ordenes"},
     *     @OA\RequestBody(
     *         description="Datos de la orden",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Orden")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Orden creada",
     *         @OA\JsonContent(ref="#/components/schemas/Orden")
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Primero, valida los datos del formulario
        $request->validate([
            // Agrega aquí tus reglas de validación
        ]);

        // Asegúrate de que la identificación del cliente existe en la tabla clientes
        $cliente = Cliente::where('identificacion', $request->input('id_cliente'))->first();
        if (!$cliente) {
            // Si el cliente no existe, devuelve un error
            return response()->json([
                'message' => 'La identificación del cliente no existe en la tabla clientes.'
            ], 400);
        }

        // Si el cliente existe, crea la orden
        $orden = Orden::create($request->all());

        return response()->json($orden, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/ordens/{id}",
     *     summary="Obtiene una orden por ID",
     *     tags={"Ordenes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la orden",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Orden")
     *     )
     * )
     */
    public function show(Orden $orden)
    {
        return response()->json($orden);
    }

    /**
     * @OA\Put(
     *     path="/api/ordens/{id}",
     *     summary="Actualiza una orden por ID",
     *     tags={"Ordenes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la orden",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Datos de la orden",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Orden")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Orden")
     *     )
     * )
     */
    public function update(Request $request, Orden $orden)
    {
        $orden->update($request->all());
        return response()->json($orden);
    }

    /**
     * @OA\Delete(
     *     path="/api/ordens/{id}",
     *     summary="Elimina una orden por ID",
     *     tags={"Ordenes"},
     * @OA\Parameter(
    * name="id",
    * in="path",
    * description="ID de la orden",
    * required=true,
    * @OA\Schema(type="integer")
    * ),
    * @OA\Response(
    * response=200,
    * description="Orden eliminada",
    * @OA\JsonContent(ref="#/components/schemas/Orden")
    * )
    * )
    */
    public function destroy(Orden $orden)
    {
        $orden->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *      path="/api/ordenes/entregados/{cedula}",
     *      summary="Obtener órdenes entregadas por número de cédula",
     *      tags={"Ordenes"},
     *      @OA\Parameter(
     *          name="cedula",
     *          in="path",
     *          required=true,
     *          description="Número de cédula del cliente",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="ordenes",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Orden")
     *              ),
     *              @OA\Property(
     *                  property="cantidad",
     *                  type="integer",
     *                  description="Cantidad de órdenes entregadas"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No se encontraron órdenes entregadas para la cédula proporcionada"
     *      )
     * )
     */
    public function entregadosPorCedula($cedula)
    {
        $ordens = Orden::whereHas('cliente', function ($query) use ($cedula) {
            $query->where('identificacion', $cedula);
        })->whereHas('estado_orden', function ($query) {
            $query->where('nombre', 'ENTREGADO');
        })->get();

        $cantidad = $ordens->count();

        return response()->json([
            'ordenes' => $ordens,
            'cantidad' => $cantidad,
        ]);
    }
}
