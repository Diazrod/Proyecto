<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FinanzasController extends Controller
{
    public function cuenta()
    {
        $tipo = 'CUENTA';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/api/finanzas?tablaTipo=' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                return view('cuenta')->with('ResultadosCuenta', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->with('error', 'Error al obtener datos de cuenta');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
        }
    }

    public function obtenerCuentas()
{
    $tipo = 'CUENTA';
    
    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/api/finanzas?tablaTipo=' . $tipo);
    
        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            $cuentas = $response->json(); // Asignar los datos a la variable $cuentas
            return view('tu-vista', ['cuentas' => $cuentas]); // Pasar los datos a la vista
        } else {
            // Retornar un error en caso de fallo
            return response()->json(['error' => 'Error al obtener datos de cuenta'], 500);
        }
    } catch (\Exception $e) {
        // Retornar un error en caso de excepción
        return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
    }
}



    public function consultaMes()
    {
        $tipo = 'CONSULTA MES';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/api/finanzas?tablaTipo=' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                return view('consulta_mes')->with('ResultadosConsultaMes', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->with('error', 'Error al obtener datos de consulta del mes');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
        }
    }

    public function financa()
    {
        $tipo = 'FINANZA';
        
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/api/finanzas?tablaTipo=' . $tipo);
        
            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                return view('finanza')->with('ResultadosFinanza', $response->json());
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->with('error', 'Error al obtener datos de finanza');
            }
        } catch (\Exception $e) {
            // Redirigir a la página principal en caso de excepción
            return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
        }
    }
    
    /*****************************ins finanzas********************************* */
    public function crearFinanzas(Request $request)
{
    // Datos de la finanza obtenidos del formulario
    $datos = [
        'P_TIPO_TABLA' => 'FINANZAS',
        'P_NOM_CUENTA' => 'S', 
        'P_TIPO_CUENTA' =>'INGRESO',
        'P_COD_CUENTA' => $request->input('cod_cuenta'),
        'P_OBSERVACIONES' => $request->input('observaciones'),
        'P_TIPO_TRANSACCION' => $request->input('tipo_trans'),
        'P_MONTO' => $request->input('monto'),
        'P_FECHA' => $request->input('fecha')
    ];

    // URL de tu API externa donde insertas la finanza
    $urlAPI = "http://localhost:3000/finanzas";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Finanza registrada con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar la finanza. Estado: ' . $response->status() . ' Respuesta: ' . $response->body());
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}




    /*****************************ins finanzas********************************* */
    public function crearcuenta(Request $request)
{
    // Datos de la finanza obtenidos del formulario
    $datos = [
        'P_TIPO_TABLA' => 'CUENTA',
        'P_NOM_CUENTA' => $request->input('nombre'), 
        'P_TIPO_CUENTA' =>$request->input('tipo_cuenta'),
        'P_COD_CUENTA' => '0',
        'P_OBSERVACIONES' => 'S',
        'P_TIPO_TRANSACCION' => 'INGRESO',
        'P_MONTO' => '10.00',
        'P_FECHA' => '2018-09-01',
    ];

    // URL de tu API externa donde insertas la finanza
    $urlAPI = "http://localhost:3000/finanzas";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Cuenta registrada con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar la Cuenta. Estado: ' . $response->status() . ' Respuesta: ' . $response->body());
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}












///update de finanzas///////////////////////////////
public function updateREGFinanzas(Request $request, $id)
{
    // ID del registro de finanzas a actualizar
    $id = $request->input('modificar_id'); 

    // Datos del formulario para actualizar el registro de finanzas
    $datos = [
        'P_TIPO_TABLA' => 'FINANZAS',
        'P_NOM_CUENTA' =>'0',
        'P_TIPO_CUENTA' => 'INGRESO',
        'P_COD_CUENTA' => $request->input('modificar_codcuenta'), // Utiliza el ID recibido para identificar el registro
        'P_OBSERVACIONES' => $request->input('modificar_observaciones'), // Asegúrate de que esto se ajuste a tus necesidades
        'P_TIPO_TRANSACCION' => $request->input('modificar_tipo_trans'), // Ajusta según la lógica de tu aplicación
        'P_MONTO' =>$request->input('modificar_monto'), // Asegúrate de que esto se ajuste a tus necesidades
        'P_FECHA' =>$request->input('modificar_fecha'), // Ajusta según la lógica de tu aplicación
    ];

    // URL de tu API externa para actualizar el registro de finanzas específico
    $urlAPI = "http://localhost:3000/finanzas/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro de finanzas actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro de finanzas. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}


public function updateFinanzas(Request $request, $id)
{
    // ID del registro de finanzas a actualizar
    $id = $request->input('cuenta_id'); 

    // Datos del formulario para actualizar el registro de finanzas
    $datos = [
        'P_TIPO_TABLA' => 'CUENTA',
        'P_NOM_CUENTA' => $request->input('nombre'),
        'P_TIPO_CUENTA' => $request->input('tipo_cuenta'),
        'P_COD_CUENTA' => $id, // Utiliza el ID recibido para identificar el registro
        'P_OBSERVACIONES' => '0', // Asegúrate de que esto se ajuste a tus necesidades
        'P_TIPO_TRANSACCION' => 'INGRESO', // Ajusta según la lógica de tu aplicación
        'P_MONTO' => '0', // Asegúrate de que esto se ajuste a tus necesidades
        'P_FECHA' => '2024-07-11' // Ajusta según la lógica de tu aplicación
    ];

    // URL de tu API externa para actualizar el registro de finanzas específico
    $urlAPI = "http://localhost:3000/finanzas/{$id}";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro de finanzas actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro de finanzas. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}





}//fin controlador
