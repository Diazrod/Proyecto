<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class BecasController extends Controller
{
    public function becas()
{
    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/becas');
        
        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            $becas = $response->json();
            // Convertir los datos en una colección de objetos
            $becas = collect($becas)->map(function ($item) {
                return (object) $item;
            });
            // Pasar los datos a la vista
            return view('becas')->with('becas', $becas);
        } else {
            // Redirigir a la página principal en caso de error
            return redirect('/')->withErrors(['error' => 'No se pudieron obtener los datos de las becas.']);
        }
    } catch (\Exception $e) {
        // Manejar excepciones y redirigir en caso de error
        return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
    }
}


/////beca insert
public function insertarBeca(Request $request)
{
    // Datos de la beca obtenidos del formulario
    $datos = [
        'p_cod_personas' => $request->input('COD_PERSONAS'),
        'p_carrera' => $request->input('CARRERA'),
        'p_duracion' => $request->input('DURACION'),
        'p_ayuda' => $request->input('AYUDA'),
        'p_horas_trabajo_pastoral' => $request->input('HORAS_TRABAJO_PASTORAL'),
        'p_registro_avance' => $request->input('REGISTRO_AVANCE'),
        'p_estado' => $request->input('ESTADO'),
        'p_fecha_inicio' => $request->input('FECHA_INICIO'),
        'p_fecha_fin' => $request->input('FECHA_FIN'),
        'p_observaciones' => $request->input('OBSERVACIONES')
    ];

    // URL de tu API externa donde insertas la beca
    $urlAPI = "http://localhost:3000/becas";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            return redirect()->back()->with('success', 'Beca registrada con éxito.');
        } else {
            // Redirigir con un mensaje de error detallado en caso de fallo
            return redirect()->back()->withErrors(['error' => 'Error al registrar la beca. Estado: ' . $response->status() . ' Respuesta: ' . $response->body()]);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->withErrors(['error' => 'Excepción capturada', 'message' => $e->getMessage()]);
    }
}




public function updateBeca(Request $request, $id)
{
    // Obtener el ID directamente desde el request
    $id = $request->input('p_cod_beca');

    // Datos del formulario para actualizar la beca
    $datos = [
        'p_cod_personas' => $request->input('p_cod_Persona'),
        'p_carrera' => $request->input('CARRERA'),
        'p_duracion' => $request->input('DURACION'),
        'p_ayuda' => $request->input('p_ayuda'),
        'p_horas_trabajo_pastoral' => $request->input('HORAS_TRABAJO_PASTORAL'),
        'p_registro_avance' => $request->input('REGISTRO_AVANCE'),
        'p_estado' => $request->input('p_estado'),
        'p_fecha_inicio' => $request->input('p_fecha_inicio'),
        'p_fecha_fin' => $request->input('p_fecha_fin'),
        'p_observaciones' => $request->input('OBSERVACIONES')
    ];

    // URL de tu API externa para actualizar la beca específica
    $urlAPI = "http://localhost:3000/becas/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Beca actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar la beca. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}















}// fin del Controlador 
