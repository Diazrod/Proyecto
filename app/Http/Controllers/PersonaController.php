<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Personas;
use Illuminate\Support\Facades\Session; 

class PersonaController extends Controller
{
 

    public function obtenerPersonas()
    {
        // Obtener las personas desde la base de datos
        $personas = Personas::all();
    
        // Devolver los datos en formato JSON
        return response()->json($personas);
    }
 
    public function Feligreses()
    {
        $tipo = 'PERSONAS';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/Bpersonas/' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                return view('Feligreses')->with('ResulPersonas', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
        }
    }

    public function crearPersona(Request $request)
    {
       
        $tipo = 'PERSONAS';
        $persona = [
            'PE_TIP_TABLA' => $tipo,
            'pr_nombre' => $request->input('pr_nombre'),
            'sg_nombre' => $request->input('sg_nombre'),
            'pr_apellido' => $request->input('pr_apellido'),
            'sg_apellido' => $request->input('sg_apellido'),
            'dni_persona' => $request->input('dni_persona'),
            'num_telefono' => $request->input('num_telefono'),
            'fech_nacimiento' => $request->input('fech_nacimiento'),
            'genero' => $request->input('genero'),
            'personeria' => $request->input('personeria'),
            'est_civil' => $request->input('est_civil'),
            'nom_depto' => $request->input('nom_depto'),
            'municipio' => $request->input('municipio'),
            'nom_barrio' => $request->input('nom_barrio'),
            'nom_calle' => $request->input('nom_calle'),
            'cod_persona_existente' => '1',
            'nom_area' => 'ninguno',
            'fech_contrato' => '0000-00-00',
            'salario' => '0',
            'est_empleado' => 'inactivo'
        ];

        $urlAPI = "http://localhost:3000/personas";

        try {
            // Llamar a la API del servidor
            $response = Http::post($urlAPI, $persona);

            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                return redirect()->back()->with('success', 'Persona registrada con éxito.');
            } else {
                // Capturar el mensaje de error específico de la respuesta
                $error = $response->json();
                $errorMessage = isset($error['sqlMessage']) ? $error['sqlMessage'] : 'Error: la persona ya está registrada en personas.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }

   
// Función para actualizar una persona
public function actualizarPersona(Request $request, $id)
{
    $tipo = 'PERSONAS';
    $persona = [
        'PE_TIP_TABLA' => $tipo,
        'pr_nombre' => $request->input('pr_nombre'),
        'sg_nombre' => $request->input('sg_nombre'),
        'pr_apellido' => $request->input('pr_apellido'),
        'sg_apellido' => $request->input('sg_apellido'),
        'dni_persona' => $request->input('dni_persona'),
        'num_telefono' => $request->input('num_telefono'),
        'fech_nacimiento' => $request->input('fech_nacimiento'),
        'genero' => $request->input('genero'),
        'personeria' => $request->input('personeria'),
        'est_civil' => $request->input('est_civil'),
        'nom_depto' => $request->input('nom_depto'),
        'municipio' => $request->input('municipio'),
        'nom_barrio' => $request->input('nom_barrio'),
        'nom_calle' => $request->input('nom_calle'),
        'cod_persona_existente' => '1',
        'nom_area' => 'ninguno',
        'fech_contrato' => '0000-00-00',
        'salario' => '0',
        'est_empleado' => 'inactivo'
    ];
    $urlAPI = "http://localhost:3000/personas/$id";

    try {
        // Llamar a la API del servidor para actualizar la persona
        $response = Http::put($urlAPI, $persona);

        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            return redirect()->back()->with('success', 'Persona actualizada con éxito.');
        } else {
            // Capturar el mensaje de error específico de la respuesta
            $error = $response->json();
            $errorMessage = isset($error['sqlMessage']) ? $error['sqlMessage'] : 'Error al actualizar la persona.';
            return redirect()->back()->with('error', $errorMessage);
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}

// Función para obtener una persona por su ID
public function obtenerPersonaPorId($id)
{
    $urlAPI = "http://localhost:3000/personas/$id";

    try {
        // Llamar a la API del servidor para obtener la persona
        $response = Http::get($urlAPI);

        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            $persona = $response->json();

   // Convertir la fecha de nacimiento al formato YYYY-MM-DD
   if (isset($persona['FECH_NACIMINETO'])) {
    $persona['FECH_NACIMINETO'] = Carbon::parse($persona['FECH_NACIMINETO'])->format('Y-m-d');
}

            return view('persona.detalle', compact('persona'));
        } else {
            // Capturar el mensaje de error específico de la respuesta
            $error = $response->json();
            $errorMessage = isset($error['error']) ? $error['error'] : 'Error al obtener la persona.';
            return redirect()->back()->with('error', $errorMessage);
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}




}

