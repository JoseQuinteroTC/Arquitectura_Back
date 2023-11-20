<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedidos;

class PedidosController extends Controller
{
    //
    public function carrito(Request $request)
    {
        $pedido = Pedidos::create([
            'user_id' => $request->user_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
            'carrito' => $request->carrito,

        ]);

        return response()
            ->json(['data' => $pedido,]);
    }

    public function mostrarCarrito($user_id)
    {
        $pedido = Pedidos::find($user_id);

        return response()
            ->json($pedido);
    }

}
