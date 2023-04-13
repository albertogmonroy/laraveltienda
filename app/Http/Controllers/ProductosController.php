<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Validations\validacionesProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    public function obtenerProducto($id)
    {
        try {
            $productos = Producto::find();
            if ($productos->isEmpty()) {
                return response()->json([
                    'error' => 'No se encontró el producto'
                ], 404);
            }
            return response()->json([
                'estatus' => 'ok',
                'message' => 'Producto Encontrado',
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
                Log::channel('warning')->warning('Advertencia al agregar el producto', ['mensaje' => 'Validación de datos fallida', 'datos' => $request->all()]);

                return response()->json([
                    'estatus' => 'error',
                    'message' => 'Ocurrió un error al intentar agregar el producto',
                    'data'    => $validaciones->errors()
                ], 404);
            }
            $producto = Producto::create($request->all());
            if (!$producto) {
                DB::rollBack();
                Log::channel('warning')->error('Error al agregar el producto', ['mensaje' => 'No se pudo agregar el producto', 'datos' => $request->all()]);
                return response()->json([
                    'estatus' => 'error',
                    'message' => 'Ocurrió un error al intentar agregar el producto',
                    'data'    => 'intente de nuevo'
                ], 404);
            }
            DB::commit();
            Log::channel('info')->info('Producto agregado correctamente', ['producto_id' => $producto->id]);
            return response()->json([
                'estatus' => 'ok',
                'message' => 'El Producto se ha agregado correctamente',
                'data'    => $producto
            ], 201);
        } catch (\Exception $e) {
            Log::channel('error')->error('Error al agregar el producto', ['mensaje' => $e->getMessage(), 'datos' => $request->all()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function actualizarProducto(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $producto = Producto::find($id);
            if (!$producto) {
                DB::rollBack();
                Log::channel('warning')->warning('Advertencia al actualizar el producto', ['mensaje' => 'El producto no existe', 'producto_id' => $id]);

                return response()->json([
                    'estatus' => 'error',
                    'message' => 'El Producto no existe',
                    'data'    => null
                ], 404);
            }
            $validaciones = Validator::make($request->all(), $this->validacionesGenerales, $this->validacionSubmitProducto);
            if ($validaciones->fails()) {
                DB::rollBack();
                Log::channel('warning')->warning('Advertencia al actualizar el producto', ['mensaje' => 'La información proporcionada es incorrecta', 'producto_id' => $id]);

                return response()->json([
                    'estatus' => 'error',
                    'message' => 'Ocurrió un error al intentar actualizar el producto',
                    'data'    => $validaciones->errors()
                ], 404);
            }
            $producto->update($request->all());
            DB::commit();
            return response()->json([
                'estatus' => 'ok',
                'message' => 'El Producto se ha actualizado correctamente',
                'data'    => $producto
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function eliminarProducto($id)
    {
        try {
            DB::beginTransaction();

            // Buscamos el producto a eliminar
            $producto = Producto::find($id);

            // Si no existe, devolvemos un error
            if (!$producto) {
                Log::channel('producto')->warning("No se pudo eliminar el producto con ID $id, no existe en la base de datos.");
                return response()->json([
                    'estatus' => 'error',
                    'message' => "No se pudo eliminar el producto con ID $id, no existe en la base de datos.",
                    'data'    => null
                ], 404);
            }

            // Eliminamos el producto
            $producto->delete();

            DB::commit();

            Log::channel('producto')->info("El producto con ID $id ha sido eliminado exitosamente de la base de datos.");
            return response()->json([
                'estatus' => 'ok',
                'message' => "El producto con ID $id ha sido eliminado exitosamente de la base de datos.",
                'data'    => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('producto')->error("Ocurrió un error al intentar eliminar el producto con ID $id: " . $e->getMessage());
            return response()->json([
                'estatus' => 'error',
                'message' => "Ocurrió un error al intentar eliminar el producto con ID $id",
                'data'    => null
            ], 500);
        }
    }
}
