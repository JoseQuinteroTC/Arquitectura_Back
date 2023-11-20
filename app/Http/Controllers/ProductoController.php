<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    //
    public function showAll()
    {
        $product = Producto::all();

        return $product;
    }

    public function showId($id)
    {
        $producto = Producto::find($id);

        return response()
            ->json($producto);
    }

    public function findName($name)
    {
        $producto = Producto::where('name', 'LIKE', '%' . $name)->get();
        return response()
            ->json($producto);
    }

    public function updateData(Request $request)
    {
        $producto = Producto::findOrFail($request->id);


        $validator = validator::make($request->all(), [
            'email' => 'required|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json("Ya existe un usuario con el correo ingresado", 401);
        }


        $producto->nombre = $request->nombre;
        $producto->categoria = $request->categoria;
        $producto->unidad_de_medida = $request->unidad_de_medida;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->cantidad = $request->cantidad;
        $producto->save();

        return response()
            ->json(['data' => $producto,]);
    }

    public function deleteProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()
            ->json(['status' => 'eliminado',]);
    }

    public function crearProducto(Request $request)
    {

        $validator = validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'unidad_de_medida' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|integer',
            'cantidad' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'user_id' => $request->user_id,
            'unidad_de_medida' => $request->unidad_de_medida,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,

        ]);

        return response()
            ->json(['data' => $producto,]);
    }


}
