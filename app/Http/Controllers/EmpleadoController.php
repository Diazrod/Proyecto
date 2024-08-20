<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Personas;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $personas = Personas::all();
        $empleados = Empleado::with('persona')->where('EST_EMPLEADO', 'Activo')->get();
        return view('empleados.index', compact('empleados', 'personas'));
    }
    

    public function create()
    {
        return view('empleados.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'COD_PERSONAS' => 'required|exists:personas,COD_PERSONAS',
            'NOM_AREA' => 'required',
            'FECH_CONTRATO' => 'required|date',
            'SALARIO' => 'required|numeric',
            'EST_EMPLEADO' => 'required',
        ]);
    
        Empleado::create([
            'COD_PERSONAS' => $request->input('COD_PERSONAS'),
            'NOM_AREA' => $request->input('NOM_AREA'),
            'FECH_CONTRATO' => $request->input('FECH_CONTRATO'),
            'SALARIO' => $request->input('SALARIO'),
            'EST_EMPLEADO' => $request->input('EST_EMPLEADO'),
        ]);
    
        return redirect()->route('empleados.index')->with('success', 'Empleado creado con éxito.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'COD_PERSONAS' => 'required|exists:personas,COD_PERSONAS',
            'NOM_AREA' => 'required',
            'FECH_CONTRATO' => 'required|date',
            'SALARIO' => 'required|numeric',
            'EST_EMPLEADO' => 'required',
        ]);
    
        $empleado = Empleado::find($id);
    
        if (!$empleado) {
            return redirect()->back()->withErrors(['Empleado no encontrado.']);
        }
    
        $empleado->COD_PERSONAS = $request->input('COD_PERSONAS');
        $empleado->NOM_AREA = $request->input('NOM_AREA');
        $empleado->FECH_CONTRATO = $request->input('FECH_CONTRATO');
        $empleado->SALARIO = $request->input('SALARIO');
        $empleado->EST_EMPLEADO = $request->input('EST_EMPLEADO');
    
        $empleado->save();
    
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado con éxito.');
    }
    
    public function show($id)
    {
        $empleado = Empleado::with('persona')->findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }



    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado con éxito.');
    }
}
