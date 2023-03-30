<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Validations\validacionesProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    //
    use validacionesProductos;

    public function obtenerProductos()
    {
        try {
            $productos = Producto::all();
            if ($productos->isEmpty()) {
                return response()->json([
                    'error' => 'No se pudieron lozalizar productos'
                ], 404);
            }
            return response()->json([
                'estatus' => 'ok',
                'message' => 'Productos Encontrados',
                'data'    => $productos
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function guardarProducto(Request $request)
    {
        try {
            DB::beginTransaction();
            /* Validación de los datos recibidos */
            $validaciones = Validator::make($request->all(), $this->validacionesGenerales, $this->validacionSubmitProducto);
            if ($validaciones->fails()) {
                DB::rollBack();
                return response()->json([
                    'estatus' => 'error',
                    'message' => 'Ocurrió un error al intentar agregar el producto',
                    'data'    => $validaciones->errors()
                ], 404);
            }
            $producto = Producto::create($request->all());
            if (!$producto) {
                DB::rollBack();
                return response()->json([
                    'estatus' => 'error',
                    'message' => 'Ocurrió un error al intentar agregar el producto',
                    'data'    => 'intente de nuevo'
                ], 404);
            }
            DB::commit();
            return response()->json([
                'estatus' => 'ok',
                'message' => 'El Producto se ha agregado correctamente',
                'data'    => $producto
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
