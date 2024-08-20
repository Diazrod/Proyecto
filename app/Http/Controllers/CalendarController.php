<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalendarController extends Controller
{
    public function index(){
        return view('Calendar\index');
    }

    public function tipo_eventos()
    {
        $tipo = 'TIPO_EVENTOS';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/agenda/' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                return view('tipo_eventos')->with('ResulEventos', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->with('error', 'Error al obtener datos de cuenta');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
        }
    }

    public function buscar_eventos()
    {
        $tipo = 'TIPO_EVENTOS';

        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/agenda/' . $tipo);

            // Verificar si la respuesta es exitosa
            if ($response->successful()) {
                // Retornar los datos como JSON para DataTables
                return response()->json([
                    'data' => $response->json() // Asegúrate de que esta es la propiedad correcta en la respuesta
                ]);
            } else {
                // Redirigir a la página principal en caso de error
                return response()->json(['error' => 'No se pudo obtener los datos de tipo de evento.'], 500);
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return response()->json(['error' => 'Error en la solicitud: ' . $e->getMessage()], 500);
        }
    }


     public function agenda()
     {
         $tipo = 'AGENDA';
         
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/agenda/' . $tipo);
         
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('agenda')->with('ResulAgenda', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
         }
     }

     public function solicitud_servicios()
     {
         $tipo = 'SOLICITUD_SERVICIOS';
         
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/agenda/' . $tipo);
         
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('solicitud_servicios')->with('ResulSolicitud', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
         }
     }



// ******************************* funcion para ingresar tipo de evento *******************************

public function crearEvento(Request $request)
{
    $tipo = 'TIPO_EVENTOS';

    // Datos del EVENTO obtenidos del formulario
    $datos = [
        'p_tabla_tipo' => $tipo,
        'p_nombre' => $request->input('NOMBRE'),
        'p_cod_tip_evento' => $request->input('COD_TIP_EVENTO'),
        'p_fec_hrs_evento' => '2024-06-25 ',
        'p_duracion_evento' => '15:00:00',
        'p_lugar' => 'a',
        'p_descripcion' => 'a',
        'p_responsable' => 'a',
        'p_estado' => '0',
        'p_observaciones' => 'a',
        'p_desc_evento' => 'a',
        'p_nom_solicitante' => 'a',
        'p_tel_solicitante' => 'a',
        'p_fec_hrs_servicio' => '2024-06-25 15:00:00',
        'p_obs_solicitud'  => 'a',
        'p_fec_registro' => '2024-07-11'
        
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/agenda";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Tipo de Evento registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el Evento.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}


public function crearAgenda(Request $request)
{
    $tipo = 'AGENDA';

    // Datos del EVENTO obtenidos del formulario
    $datos = [
        'p_tabla_tipo' => $tipo,
        'p_nombre' => 'a',
        'p_cod_tip_evento' => $request->input('COD_TIP_EVENTO'),
        'p_fec_hrs_evento' => $request->input('FEC_HRS_EVENTO'),
        'p_duracion_evento' => $request->input('DURACION_EVENTO'),
        'p_lugar' => $request->input('LUGAR'),
        'p_descripcion' => $request->input('DESCRIPCION'),
        'p_responsable' => $request->input('RESPONSABLE'),
        'p_estado' => $request->input('ESTADO'),
        'p_observaciones' => $request->input('OBSERVACIONES'),
        'p_desc_evento' => 'a',
        'p_nom_solicitante' => 'a',
        'p_tel_solicitante' => 'a',
        'p_fec_hrs_servicio' => '2024-06-25 15:00:00',
        'p_obs_solicitud'  => 'a',
        'p_fec_registro' => '2024-07-11'
        
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/agenda";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Evento registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el Evento.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}


public function crearSolicitud(Request $request)
{
    $tipo = 'SOLICITUD_SERVICIOS';

    // Datos del EVENTO obtenidos del formulario
    $datos = [
        'p_tabla_tipo' => $tipo,
        'p_nombre' => 'a',
        'p_cod_tip_evento' => $request->input('COD_TIP_EVENTO'),
        'p_fec_hrs_evento' => '2024-06-25 15:00:00',
        'p_duracion_evento' => '15:00:00',
        'p_lugar' => $request->input('LUGAR'),
        'p_descripcion' => 'a',
        'p_responsable' => 'a',
        'p_estado' => '0',
        'p_observaciones' => 'a',
        'p_desc_evento' => $request->input('DESC_EVENTO'),
        'p_nom_solicitante' => $request->input('NOM_SOLICITANTE'),
        'p_tel_solicitante' => $request->input('TEL_SOLICITANTE'),
        'p_fec_hrs_servicio' => $request->input('FEC_HRS_SERVICIO'),
        'p_obs_solicitud' => $request->input('OBSERVACION'),
        'p_fec_registro' => $request->input('FEC_REGISTRO'),
        'p_estado' => $request->input('ESTADO')
        
    ];

    // URL de tu API externa donde insertas 
    $urlAPI = "http://localhost:3000/agenda";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Solicitud registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar la Solicitud.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}



////////////////////////////////////////////////////////////////////////////////////
public function updateTipo_evento(Request $request, $id)
{
    $id = $request->input('COD_TIP_EVENTO');

    // Datos del formulario para actualizar la beca
    $datos = [
        'p_tabla_tipo' => 'TIPO_EVENTOS',
        'p_nombre' => $request->input('NOMBRE'),
        'p_fec_hrs_evento' => '2024-06-25',
        'p_duracion_evento' => '15:00:00',
        'p_lugar' => 'a',
        'p_descripcion' => 'a',
        'p_responsable' => 'a',
        'p_estado' => '0',
        'p_observaciones' => 'a',
        'p_desc_evento' => 'a',
        'p_nom_solicitante' => 'a',
        'p_tel_solicitante' => 'a',
        'p_fec_hrs_servicio' => '2024-06-25 15:00:00',
        'p_obs_solicitud' => 'a',
        'p_fec_registro' => '2024-07-11'
    ];

    // URL de tu API externa para actualizar el evento específico
    $urlAPI = "http://localhost:3000/agenda/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Tipo evento actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el tipo. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}

public function updateAgenda(Request $request, $id)
{
    $id = $request->input('COD_EVENTO');

    // Datos del formulario para actualizar la beca
    $datos = [
        'p_tabla_tipo' => 'AGENDA',
        'p_nombre' => 'a',
        'p_cod_tip_evento' => $request->input('COD_TIP_EVENTO'),
        'p_fec_hrs_evento' => $request->input('FEC_HRS_EVENTO'),
        'p_duracion_evento' => $request->input('DURACION_EVENTO'),
        'p_lugar' => $request->input('LUGAR'),
        'p_descripcion' => $request->input('DESCRIPCION'),
        'p_responsable' => $request->input('RESPONSABLE'),
        'p_estado' => $request->input('ESTADO'),
        'p_observaciones' => $request->input('OBSERVACIONES'),
        'p_desc_evento' => 'a',
        'p_nom_solicitante' => 'a',
        'p_tel_solicitante' => 'a',
        'p_fec_hrs_servicio' => '2024-06-25 15:00:00',
        'p_obs_solicitud'  => 'a',
        'p_fec_registro' => '2024-07-11'
    ];

    // URL de tu API externa para actualizar el evento específico
    $urlAPI = "http://localhost:3000/agenda/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Evento actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el tipo. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}

public function updateSolicitud(Request $request, $id)
{
    $id = $request->input('COD_SOLICITUD');

    // Datos del formulario para actualizar la beca
    $datos = [
        'p_tabla_tipo' => 'SOLICITUD_SERVICIOS',
        'p_nombre' => 'a',
        'p_cod_tip_evento' => $request->input('COD_TIP_EVENTO'),
        'p_fec_hrs_evento' => '2024-06-25 15:00:00',
        'p_duracion_evento' => '15:00:00',
        'p_lugar' => $request->input('LUGAR'),
        'p_descripcion' => 'a',
        'p_responsable' => 'a',
        'p_estado' => '0',
        'p_observaciones' => 'a',
        'p_desc_evento' => $request->input('DESC_EVENTO'),
        'p_nom_solicitante' => $request->input('NOM_SOLICITANTE'),
        'p_tel_solicitante' => $request->input('TEL_SOLICITANTE'),
        'p_fec_hrs_servicio' => $request->input('FEC_HRS_SERVICIO'),
        'p_obs_solicitud' => $request->input('OBSERVACION'),
        'p_fec_registro' => $request->input('FEC_REGISTRO'),
        'p_estado' => $request->input('ESTADO')
    ];

    // URL de tu API externa para actualizar el evento específico
    $urlAPI = "http://localhost:3000/agenda/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Solicitud actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el tipo. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}
}


