<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function solicitudAyudaSocial()
    {
        $tipo = 'SOLICITUD_AYUDA_SOCIAL';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/selectSocial/' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->successful()) {
                // Pasar los datos a la vista 'solicitud_ayuda_social'
                return view('solicitud_ayuda')->with('solicitudes', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->withErrors('No se pudo obtener los datos de la solicitud de ayuda social.');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return redirect('/')->withErrors('Error en la solicitud: ' . $e->getMessage());
        }
    }







    public function tipo_proyectos()
    {
        $tipo = 'TIPO_PROYECTO';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/selectSocial/' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->successful()) {
                // Pasar los datos a la vista 'solicitud_ayuda_social'
                return view('tipo_Proyectos')->with('Tipo', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->withErrors('No se pudo obtener los datos de tipo de proyectos.');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return redirect('/')->withErrors('Error en la solicitud: ' . $e->getMessage());
        }
    }




    public function buscar_proyecto()
{
    $tipo = 'TIPO_PROYECTO';

    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/selectSocial/' . $tipo);

        // Verificar si la respuesta es exitosa
        if ($response->successful()) {
            // Retornar los datos como JSON para DataTables
            return response()->json([
                'data' => $response->json() // Asegúrate de que esta es la propiedad correcta en la respuesta
            ]);
        } else {
            // Redirigir a la página principal en caso de error
            return response()->json(['error' => 'No se pudo obtener los datos de tipo de proyectos.'], 500);
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return response()->json(['error' => 'Error en la solicitud: ' . $e->getMessage()], 500);
    }
}





    public function proyectos()
    {
        $tipo = 'PROYECTOS';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/selectSocial/' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->successful()) {
                // Pasar los datos a la vista 'solicitud_ayuda_social'
                return view('proyectos')->with('Proyectos', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->withErrors('No se pudo obtener los datos de tipo de proyectos.');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return redirect('/')->withErrors('Error en la solicitud: ' . $e->getMessage());
        }
    }



public function crearSolicitud(Request $request)
{
    $tipo = 'SOLICITUD_AYUDA_SOCIAL';

    // Datos del bautizo obtenidos del formulario
    $datos = [
        'P_TABLA_TIPO' => $tipo, // Asegúrate de que este parámetro esté definido en tu API
        'P_NOMBRE' => 'a',
        'P_COD_TIPO_PROYECTO' =>'0',
        'P_NOMBRE_PROYECTO' => 'a',
        'P_OBSERVACIONES_PROYECTO' => 'a',
        'P_FEC_INICIO' =>'2024-07-11',
        'P_FEC_FIN' => '2024-07-11',
        'P_RECURSOS_NECESARIOS' => 'a',
        'P_ESTADO_PROYECTO' => 'PLANIFICADO',
        'P_FEC_SOLICITUD' => $request->input('FECHA_SOLICITUD'),
        'P_TIPO_AYUDA' => $request->input('TIPO_AAYUDA'),
        'P_ESTADO_SOLICITUD' => $request->input('ESTADO'),
        'P_FEC_RESOLUCION' => $request->input('FECHA_RESOLUCION'),
        'P_OBSERVACIONES_SOLICITUD' => $request->input('OBSERVACIONES'),
        'P_COD_PERSONAS' => $request->input('CODIGO_PERSONA')
    ];

    // URL de tu API externa donde insertas el proyecto
    $urlAPI = "http://localhost:3000/insertSocial";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Registro creado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el proyecto.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}





public function crearTipo(Request $request)
{
    $tipo = 'TIPO_PROYECTO';

    // Datos del proyecto obtenidos del formulario
    $datos = [
        'P_TABLA_TIPO' => $tipo,
        'P_NOMBRE' =>  $request->input('NOMBRE'),
        'P_COD_TIPO_PROYECTO' => '0',
        'P_NOMBRE_PROYECTO' => 'a',
        'P_OBSERVACIONES_PROYECTO' => 'a',
        'P_FEC_INICIO' => '2024-07-11',
        'P_FEC_FIN' => '2024-07-11',
        'P_RECURSOS_NECESARIOS' => 'a',
        'P_ESTADO_PROYECTO' => 'PLANIFICADO',
        'P_FEC_SOLICITUD' => '2024-07-11',
        'P_TIPO_AYUDA' => 'ALIMENTARIA',
        'P_ESTADO_SOLICITUD' => 'PENDIENTE',
        'P_FEC_RESOLUCION' => '2024-07-11',
        'P_OBSERVACIONES_SOLICITUD' => 'a',
        'P_COD_PERSONAS' => '1'
    ];

    // Imprimir los datos para depuración
    \Log::info('Datos enviados a la API:', $datos);

    // URL de tu API externa donde insertas el proyecto
    $urlAPI = "http://localhost:3000/insertSocial";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Registro creado con éxito.');
        } else {
            \Log::error('Error al registrar el proyecto:', ['response' => $response->body()]);
            return redirect()->back()->with('error', 'Error al registrar el proyecto.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        \Log::error('Excepción capturada:', ['exception' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}



public function crearProyectos(Request $request)
{
    $tipo = 'PROYECTOS';

    // Datos del proyecto obtenidos del formulario
    $datos = [
        'P_TABLA_TIPO' => $tipo,
        'P_NOMBRE' =>  'a',
        'P_COD_TIPO_PROYECTO' => $request->input('COD_TIPO_PROYECTO'),
        'P_NOMBRE_PROYECTO' => $request->input('NOMBRE'),
        'P_OBSERVACIONES_PROYECTO' => $request->input('OBSERVACIONES'),
        'P_FEC_INICIO' => $request->input('FEC_INICIO'),
        'P_FEC_FIN' => $request->input('FEC_FIN'),
        'P_RECURSOS_NECESARIOS' => $request->input('RECURSOS_NECESARIOS'),
        'P_ESTADO_PROYECTO' => $request->input('ESTADO'),
        'P_FEC_SOLICITUD' => '2024-07-11',
        'P_TIPO_AYUDA' => 'ALIMENTARIA',
        'P_ESTADO_SOLICITUD' => 'PENDIENTE',
        'P_FEC_RESOLUCION' => '2024-07-11',
        'P_OBSERVACIONES_SOLICITUD' => 'a',
        'P_COD_PERSONAS' => '1'
    ];

    // Imprimir los datos para depuración
    \Log::info('Datos enviados a la API:', $datos);

    // URL de tu API externa donde insertas el proyecto
    $urlAPI = "http://localhost:3000/insertSocial";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Registro creado con éxito.');
        } else {
            \Log::error('Error al registrar el proyecto:', ['response' => $response->body()]);
            return redirect()->back()->with('error', 'Error al registrar el proyecto.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        \Log::error('Excepción capturada:', ['exception' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}












public function updateSocial(Request $request, $id)
{
    
    $id = $request->input('MODIFICAR_COD_SOLICITUD'); 

    // Datos del formulario para actualizar el registro social
    $datos = [
        'P_TABLA_TIPO' => 'SOLICITUD_AYUDA_SOCIAL',
        'P_NOMBRE' => 'a',
        'P_COD_TIPO_PROYECTO' =>'0',
        'P_NOMBRE_PROYECTO' => 'a',
        'P_OBSERVACIONES_PROYECTO' => 'a',
        'P_FEC_INICIO' =>'2024-07-11',
        'P_FEC_FIN' => '2024-07-11',
        'P_RECURSOS_NECESARIOS' => 'a',
        'P_ESTADO_PROYECTO' => 'PLANIFICADO',
        'P_FEC_SOLICITUD' => $request->input('MODIFICAR_FECHA_SOLICITUD'),
        'P_TIPO_AYUDA' => $request->input('MODIFICAR_TIPO_AAYUDA'),
        'P_ESTADO_SOLICITUD' => $request->input('MODIFICAR_ESTADO'),
        'P_FEC_RESOLUCION' => $request->input('MODIFICAR_RESOLUCION'),
        'P_OBSERVACIONES_SOLICITUD' => $request->input('MODIFICAR_OBSERVACIONES'),
        'P_COD_PERSONAS' => $request->input('MODIFICAR_DESCRIPCION')
    ];

    // Agregar registros al log para depuración
    
    // URL de tu API externa para actualizar el registro social específico
    $urlAPI = "http://localhost:3000/updateSocial/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro Solicitud actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro Solicitud. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}




public function updatetipo(Request $request, $id)
{
   
    $id = $request->input('COD_TIPO_PROYECTO'); 

   
    $datos = [
        'P_TABLA_TIPO' => 'TIPO_PROYECTO',
        'P_NOMBRE' =>  $request->input('NOMBRE'),
        'P_COD_TIPO_PROYECTO' => '0',
        'P_NOMBRE_PROYECTO' => 'a',
        'P_OBSERVACIONES_PROYECTO' => 'a',
        'P_FEC_INICIO' => '2024-07-11',
        'P_FEC_FIN' => '2024-07-11',
        'P_RECURSOS_NECESARIOS' => 'a',
        'P_ESTADO_PROYECTO' => 'PLANIFICADO',
        'P_FEC_SOLICITUD' => '2024-07-11',
        'P_TIPO_AYUDA' => 'ALIMENTARIA',
        'P_ESTADO_SOLICITUD' => 'PENDIENTE',
        'P_FEC_RESOLUCION' => '2024-07-11',
        'P_OBSERVACIONES_SOLICITUD' => 'a',
        'P_COD_PERSONAS' => '1'
    ];

    // Agregar registros al log para depuración
    
    // URL de tu API externa para actualizar el registro social específico
    $urlAPI = "http://localhost:3000/updateSocial/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro social actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro Tipo Proyectos' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}





public function updateProyecto(Request $request, $id)
{
   
    $id = $request->input('COD_PROYECTO'); 
    
    $datos = [
        'P_TABLA_TIPO' =>'PROYECTOS',
        'P_NOMBRE' =>  'a',
        'P_COD_TIPO_PROYECTO' => $request->input('COD_TIPO_PROYECTO'),
        'P_NOMBRE_PROYECTO' => $request->input('NOMBRE'),
        'P_OBSERVACIONES_PROYECTO' => $request->input('OBSERVACIONES'),
        'P_FEC_INICIO' => $request->input('FEC_INICIO'),
        'P_FEC_FIN' => $request->input('FEC_FIN'),
        'P_RECURSOS_NECESARIOS' => $request->input('RECURSOS_NECESARIOS'),
        'P_ESTADO_PROYECTO' => $request->input('ESTADO'),
        'P_FEC_SOLICITUD' => '2024-07-11',
        'P_TIPO_AYUDA' => 'ALIMENTARIA',
        'P_ESTADO_SOLICITUD' => 'PENDIENTE',
        'P_FEC_RESOLUCION' => '2024-07-11',
        'P_OBSERVACIONES_SOLICITUD' => 'a',
        'P_COD_PERSONAS' => '1'
    ];

    // Agregar registros al log para depuración
    
    // URL de tu API externa para actualizar el registro social específico
    $urlAPI = "http://localhost:3000/updateSocial/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro social actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro Tipo Proyectos' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}









}//fin del Controlador 