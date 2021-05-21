<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
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
        $usuario = User::all();
        // return view();
        return response()->json(compact('usuario'));
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
            'name' => 'required|max:255',
            'email' => 'required|max:255unique:users',
            'id_rol' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $usuario = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt('12345678')]
        ));

        if ($usuario) {
            return response()->json([
                'message' => 'usuario Registrado Correctamente',
                'usuario' => $usuario
            ], 201);
        }
        return response()->json([
            'message' => 'Error al Registrar el usuario',
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
        $usuario = User::find($id);
        // return view();
        return response()->json(compact('usuario'));
    }

    public function search($campo, $value)
    {   
        $filterData = User::where($campo,'LIKE','%'.$value.'%')
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
        $usuario = User::findOrFail($id);
        return view('edit', compact('usuario'));
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
            'name' => 'required|max:255',
            'email' => 'required|max:255unique:users',
            'id_rol' => 'required',
        ]);
        User::findOrFail($id)->update($updateData);

        if ($updateData) {
            return response()->json([
                'message' => 'Actualizado Usuario Correctamente',
                'usuario' => $updateData
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
        $usuario = User::findOrFail($id);
        $usuario->delete();

        if ($usuario) {
            return response()->json([
                'message' => 'Eliminado Correctamente',
                'usuario' => $usuario
            ], 200);
        }

        return response()->json($usuario->errors(), 400);
    }
}
