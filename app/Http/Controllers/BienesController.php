<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BienesController extends Controller
{
    public function bienes()
    {
        try {
            // Llamar a la API del servidor
            $response = Http::get('http://localhost:3000/bienes');
    
            // Verificar si la respuesta es exitosa
            if ($response->ok()) {
                $bienes = $response->json();
                // Convertir los datos en una colección de objetos
                $bienes = collect($bienes)->map(function ($item) {
                    return (object) $item;
                });
                return view('bienes')->with('bienes', $bienes);
            } else {
                // Redirigir a la página principal en caso de error
                return redirect('/')->withErrors(['error' => 'No se pudieron obtener los bienes.']);
            }
        } catch (\Exception $e) {
            // Manejar excepciones y redirigir en caso de error
            return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
        }
    }
    


    public function insertarBien(Request $request)
    {
        // Datos del bien obtenidos del formulario
        $datos = [
            'p_tip_bien' => $request->input('TIP_BIEN'),
            'p_des_objeto' => $request->input('DES_OBJETO'),
            'p_cant_bien' => $request->input('CANT_BIEN'),
            'p_costo_adquisicion' => $request->input('COSTO_ADQUISICION'),
            'p_fech_adquisicion' => $request->input('FECH_ADQUISICION'),
            'p_est_objeto' => $request->input('EST_OBJETO'),
            'p_observaciones' => $request->input('OBSERVACIONES'),
        ];

        // URL de tu API externa donde insertas el bien
        $urlAPI = "http://localhost:3000/insertBien";

        try {
            // Realizar la inserción en la base de datos externa
            $response = Http::post($urlAPI, $datos);

            if ($response->ok()) {
                return redirect()->back()->with('success', 'Bien registrado con éxito.');
            } else {
                return redirect()->back()->with('error', 'Error al registrar el bien.');
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }



    public function updateBien(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('modificarCodBien');
    
        // Datos del formulario para actualizar el bien
        $datos = [
            'p_tip_bien' => $request->input('modificarTipBien'),
            'p_des_objeto' => $request->input('modificarDesObjeto'),
            'p_cant_bien' => $request->input('modificarCantBien'),
            'p_costo_adquisicion' => $request->input('modificarCostoAdquisicion'),
            'p_fech_adquisicion' => $request->input('modificarFechAdquisicion'),
            'p_est_objeto' => $request->input('modificarEstObjeto'),
            'p_observaciones' => $request->input('modificarObservaciones')
        ];
    
        // URL de tu API externa para actualizar el bien específico
        $urlAPI = "http://localhost:3000/updateBien/{$id}";
    
        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);
    
            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Bien actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el bien. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }
















}
