<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productos = Producto::with(['user:id,email,name'])
                                ->whereCodigo($request->filter)
                                ->orWhere('nombre', 'like', "%{$request->filter }%")
                                ->paginate(50);
        return response()->json(['productos' => $productos], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductoRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $producto = Producto::create($input);
        return response()->json(['res' => true, 'message' => 'Insertado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::with(['user:id,email,name'])->findOrFail($id);
        return response()->json(['producto' => $producto], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        $input = $request->all();
        $producto = Producto::find($id);
        $producto->update($input);
        return response()->json(['res' => true, 'message' => 'Modificado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Producto::destroy($id);
            return response()->json(['res' => true, 'message'=> 'Eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['res' => false, 'message'=> $e->getMessage()]);
        }
    }

    public function setLike($id)
    {
        $producto = Producto::find($id);
        $producto->likes = $producto->likes + 1;
        $producto->save();
        return response()->json(['res' => true, 'message'=> '+1 Like'], 200);
    }

    public function setDislike($id)
    {
        $producto = Producto::find($id);
        $producto->dislikes = $producto->dislikes + 1;
        $producto->save();
        return response()->json(['res' => true, 'message'=> '+1 Dislike'], 200);
    }

    public function setImagen(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->url_imagen = $this->cargarImagen($request->imagen, $id);
        $producto->save();
        return response()->json(['res' => true, 'message'=> 'Imagen cargada correctamente'], 200);
    }

    private function cargarImagen($file, $id)
    {
        $nombreArchivo = time() . "_{$id}." . $file->getClientOriginalExtension();
        $file->move(\public_path('imagenes'), $nombreArchivo);
        return $nombreArchivo;
    }
}
