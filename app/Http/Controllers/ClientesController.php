<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente = Clientes::all();
        return response()->json(compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'documento' => 'required|max:255|unique:clientes',
            'nombre' => 'required|max:255',
            'correo' => 'required|email|max:255|unique:clientes',
            'direccion' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cliente = Clientes::create([
            'documento' => $request->documento,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
        ]);

        if ($cliente) {
            return response()->json([
                'message' => 'Cliente Registrado Correctamente',
                'cliente' => $cliente
            ], 201);
        }
        return response()->json([
            'message' => 'Error al Registrar el Cliente',
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Clientes::find($id);
        // return view();
        return response()->json(compact('cliente'));
    }

    public function search($campo, $value)
    {   
        $filterData = Clientes::where($campo,'LIKE','%'.$value.'%')
                      ->get();
        return response()->json(compact('filterData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Clientes::findOrFail($id);
        return view('edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->validate([
            'documento' => 'required|max:255',
            'nombre' => 'required|max:255',
            'correo' => 'required|email|max:255',
            'direccion' => 'required|max:255',
        ]);
        Clientes::findOrFail($id)->update($updateData);

        if ($updateData) {
            return response()->json([
                'message' => 'Actualizado Cliente Correctamente',
                'cliente' => $updateData
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->delete();

        if ($cliente) {
            return response()->json([
                'message' => 'Eliminado Correctamente',
                'cliente' => $cliente
            ], 200);
        }

        return response()->json($cliente->errors(), 400);
    }
}
