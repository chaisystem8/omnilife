<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $empleado = Empleado::where('id',$id)->first();
        $mesActual = Carbon::now()->startOfMonth();
        $salarioInicial = $empleado->salarioPesos;
        $salarioInicialD = $empleado->salarioDolares;
        $proyeccionSalario = [];

        for ($i = 0; $i < 6; $i++) {
            $mesActual->addMonth();

            $incremento = $salarioInicial * (($i + 1) * 2 / 100);
            $salarioProyectado = $salarioInicial + $incremento;

            $incrementoD = $salarioInicialD * (($i + 1) * 2 / 100);
            $salarioProyectadoD = $salarioInicialD + $incrementoD;

            $proyeccionSalario[] = [
                'mes' => $mesActual->format('F Y'), // Nombre del mes y año
                'salarioP' => $salarioProyectado,
                'salarioD' => $salarioProyectadoD,
            ];

        }

        return [
            'proyeccionSalario' => $proyeccionSalario,
            'empleado' => $empleado,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleado = Empleado::where('id',$id)->first();
        return view('empleados.edit', ['empleado' => $empleado]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'codigo' => 'required|unique:empleados,codigo,' . $id,
            'nombre' => 'required',
            'salarioP' => 'required|numeric',
            'salarioD' => 'required|numeric',
            'estado' => 'required',
            'ciudad' => 'required',
            'direccion' => 'required',
            'celular' => 'required',
            'correo' => 'required|email',
        ]);

        $empleado = Empleado::find($id);

        if ($empleado) {
            $empleado->update([
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
            return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
        } else {
            return redirect()->route('empleados.index')->with('error', 'El empleado no existe.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');

    }
}
