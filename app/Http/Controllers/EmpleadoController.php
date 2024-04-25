<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', ['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:empleados',
            'nombre' => 'required',
            'salarioP' => 'required|numeric',
            'salarioD' => 'required|numeric',
            'estado' => 'required',
            'ciudad' => 'required',
            'direccion' => 'required',
            'celular' => 'required',
            'correo' => 'required|email',
        ]);

        Empleado::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'salarioPesos' => $request->salarioP,
            'salarioDolares' => $request->salarioD,
            'estado' => $request->estado,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
            'correo' => $request->correo,
        ]);

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
