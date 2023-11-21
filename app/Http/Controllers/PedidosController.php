<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedidos;
use App\Models\Producto;

class PedidosController extends Controller
{
    //
    public function carrito(Request $request)
    {
        $pedido = Pedidos::create([
            'user_id' => $request->user_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
        ]);

        return response()
            ->json(['data' => $pedido,]);
    }

    public function mostrarCarrito($user_id)
    {
        $pedidos = Pedidos::where('user_id', 'LIKE', '%' . $user_id)->get();
        $productoUser = [];

        foreach ($pedidos as $pedido) {
            $producto = Producto::find($pedido->producto_id);
            if ($producto) {
                $producto->pedido=$pedido;
                $productoUser[] = $producto;
            }

        }


        return response()
            ->json($productoUser);

    }

}
